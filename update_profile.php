<?php
session_start();
require "dbconfig.php";
require "profiledata.php";
global $username;

if (!isset($_SESSION['loggedin'])) {
    echo "Please log in first.";
    exit;
}

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$con->set_charset("utf8mb4");

if (mysqli_connect_errno()) {
    exit('Nem lehet a MySQL szerverhez csatlakozni: ' . mysqli_connect_error());
}

$changes = []; // Array to store changes

if ($_SESSION['is_agent']) {
    // Retrieve current data
    $stmt = $con->prepare("SELECT real_name, email, phone, work_title, description FROM AGENT WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($currentRealName, $currentEmail, $currentPhone, $currentWorkTitle, $currentDescription);
    $stmt->fetch();
    $stmt->close();

    $realName = $_POST['real_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $workTitle = $_POST['work_title'] ?? '';
    $description = $_POST['description'] ?? '';

    // Check for changes and validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
        echo "Hibás email formátum.";
        exit;
    }
    if ($realName !== $currentRealName && !empty($realName)) $changes[] = "Név";
    if ($email !== $currentEmail && !empty($email)) $changes[] = "Email";
    if ($phone !== $currentPhone && !empty($phone)) $changes[] = "Telefoszám";
    if ($workTitle !== $currentWorkTitle && !empty($workTitle)) $changes[] = "Munkakör";
    if ($description !== $currentDescription && !empty($description)) $changes[] = "Leírás";

    // Update if there are changes
    if (!empty($changes)) {
        $stmt = $con->prepare("UPDATE AGENT SET real_name=?, email=?, phone=?, work_title=?, description=? WHERE username=?");
        $stmt->bind_param("ssssss", $realName, $email, $phone, $workTitle, $description, $username);
        $stmt->execute();
        echo "Az alábbi adatok változtak: " . implode(", ", $changes) . ".";
        $stmt->close();
    } else {
        echo "Nincsenek változtatások.";
    }
} else {
    // Regular user: Update only email if different and not empty
    $email = $_POST['email'] ?? '';

    $stmt = $con->prepare("SELECT email FROM USER WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($currentEmail);
    $stmt->fetch();
    $stmt->close();

    if ($email !== $currentEmail && !empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Hibás email formátum.";
            exit;
        }
        $stmt = $con->prepare("UPDATE USER SET email=? WHERE username=?");
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        echo "Változás: email.";
        $stmt->close();
    } else {
        echo "Nincsenek változtatások.";
    }
}

$con->close();

?>
