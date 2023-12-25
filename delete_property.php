<?php

session_start();
if (!isset($_SESSION['loggedin'])) {
    // Redirect to login page or show an error
    header('Location: index.php');
    exit;
}

require "dbconfig.php";
global $con;

$propertyId = $_POST['id'];
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die("Invalid property ID.");
}


// Use prepared statement to prevent SQL Injection
$stmt = $con->prepare("DELETE FROM PROPERTY WHERE id = ?;");
$stmt->bind_param("i", $propertyId); // 'i' specifies the variable type => 'integer'

if (!$stmt->execute()) {
    echo "Error deleting property: " . $stmt->error;
    exit;
}

// Prepare the statement
$stmt = $con->prepare("SELECT filename FROM PICTURE WHERE property_id = ?;");
$stmt->bind_param("i", $propertyId);
$stmt->execute();

// Bind the result to variables
$stmt->bind_result($filename);

// Fetch values
while ($stmt->fetch()) {
    if (file_exists($filename)) {
        unlink($filename);
    }
}

// Delete entries from PICTURE table in one step
$stmt = $con->prepare("DELETE FROM PICTURE WHERE property_id = ?;");
$stmt->bind_param("i", $propertyId);
if (!$stmt->execute()) {
    echo "Hiba a kép törlésekor: " . $stmt->error;
}

// Close the statement
$stmt->close();

echo "Ingatlan sikeresen törölve.
