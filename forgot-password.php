<?php
session_start();
require "dbconfig.php";
global $con;

if (!isset($_POST['email'])) {
    echo 'Az e-mail cím nincs megadva.';
    exit();
}

$email = $_POST['email'];

// Validate the email address
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Az megadott e-mail cím érvénytelen.';
    exit();
}

$found = false;
$foundAGENT = false;
$foundUSER = false;

$con->begin_transaction();
// Check in AGENT table
if ($stmt = $con->prepare('SELECT username FROM AGENT WHERE email = ?')) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($username);
    if ($stmt->fetch()) {
        $found = true;
        $foundAGENT = true;
    }
    $stmt->close();
}

// Check in USER table if not found in AGENT table
if (!$found && $stmt = $con->prepare('SELECT username FROM USER WHERE email = ?')) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($username);
    if ($stmt->fetch()) {
        $found = true;
        $foundUSER = true;
    }
    $stmt->close();
}

if ($foundAGENT and $foundUSER){
    echo 'Ez az e-mail cím két felhasználóhoz tartozik. Kérlek lépj kapcsolatba az adminisztrátorral.';
    exit();
}

// If email found in either AGENT or USER table
if ($found) {
    $tempPassword = bin2hex(random_bytes(8)); // 16 characters of hex
    $hashedTempPassword = password_hash($tempPassword, PASSWORD_DEFAULT);

    // Determine which table to update
    $tableToUpdate = $foundAGENT ? 'AGENT' : 'USER';

    // Prepare SQL query to update the password
    if ($updateStmt = $con->prepare("UPDATE $tableToUpdate SET password = ? WHERE email = ?")) {
        $updateStmt->bind_param('ss', $hashedTempPassword, $email);
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        echo 'Adatbázis hiba történt a jelszó frissítése közben.';
        $con->rollback();
        exit();
    }

    // Send email with the temporary password
    $to = $email;
    $subject = "Új ideiglenes jelszó";
    $message = "A felhasználóneved: $username \n Az ideiglenes jelszavad: $tempPassword\n Kérlek bejelentkezés után változtasd meg!";

    $headers = "From: info@madar-szakdolgozat.online\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $subject, $message, $headers)) {
        $con->commit();
        echo "Az ideglenes jelszó sikeresen elküldve a megadott e-mail címre.";
    } else {
        $con->rollback();
        echo "Hiba az email küldésekor.";
    }
} else {
    echo 'Az email címhez nem tartozik felhasználó és ügynök sem.';
}

?>
