<?php
require "dbconfig.php";
global $con;

// Define constants for maximum lengths
const maxUsernameLength = 30;
const maxEmailLength = 150;
const maxPasswordLength = 20;
const minPasswordLength = 3;

// Start the transaction


// Validation
if (empty($_POST['username']) || empty($_POST['real_name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['password_re']) || empty($_POST['work_title']) || empty($_POST['description'])) {

    exit('Kérjük, töltsd ki az összes mezőt.');
}

// Additional validations
if (strlen($_POST['username']) > maxUsernameLength) {

    exit('A felhasználónév nem lehet hosszabb, mint ' . maxUsernameLength . ' karakter!');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) || strlen($_POST['email']) > maxEmailLength) {

    exit('Az e-mail cím nem megfelelő, vagy túl hosszú!');
}

if (strlen($_POST['password']) > maxPasswordLength || strlen($_POST['password']) < minPasswordLength) {
    exit('A jelszó minimum '. minPasswordLength . " és maximum " . maxPasswordLength . " karakter hosszúságú kell legyen!");
}

if ($_POST['password'] !== $_POST['password_re']) {
    exit('A jelszavak nem egyeznek.');
}
$con->begin_transaction();
// Check if username exists
if ($stmt = $con->prepare('SELECT id FROM AGENT WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $con->rollback(); // Rollback transaction
        exit('A felhasználó név már létezik, használj másikat!');
    }
    $stmt->close();
}

// Prepare your INSERT statement
if ($stmt = $con->prepare('INSERT INTO AGENT (username, real_name, email, phone, password, work_title, description, is_admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt->bind_param('sssssssi', $_POST['username'], $_POST['real_name'], $_POST['email'], $_POST['phone'], $password, $_POST['work_title'], $_POST['description'], $_POST['is_admin']);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $con->commit(); // Commit the transaction
        echo 'Sikeres regisztráció'; // Success
    } else {
        $con->rollback(); // Rollback the transaction
        echo 'Regisztrációs hiba történt.';
    }
    $stmt->close();
} else {
    $con->rollback(); // Rollback the transaction
    echo 'SQL hiba.';
}

$con->close();
?>
