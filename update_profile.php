<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require "dbconfig.php";
require "profiledata.php";
global $username;

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    echo "Please log in first.";
    exit;
}

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Nem lehet a MySQL szerverhez csatlakozni: ' . mysqli_connect_error());
}



if ($_SESSION['is_agent']) {
    // Agent: Update all fields
    $realName = $_POST['real_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $workTitle = $_POST['work_title'] ?? '';
    $description = $_POST['description'] ?? '';

    $stmt = $con->prepare("UPDATE AGENT SET real_name=?, email=?, phone=?, work_title=?, description=? WHERE username=?");
    $stmt->bind_param("ssssss", $realName, $email, $phone, $workTitle, $description, $username);
} else {
    // Regular user: Update only email
    $email = $_POST['email'] ?? '';

    $stmt = $con->prepare("UPDATE USER SET email=? WHERE username=?");
    $stmt->bind_param("ss", $email, $username);
}

if ($stmt->execute()) {
    echo "Sikeres módosítás.";
} else {
    echo "Hiba az adatok mentésekor: " . $stmt->error;
}

$stmt->close();
$con->close();

?>
