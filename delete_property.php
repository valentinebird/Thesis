<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require "dbconfig.php";

$propertyId = $_POST['id'];

echo $propertyId;

$conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    die("Invalid property ID.");
}

echo "1";

// Use prepared statement to prevent SQL Injection
$stmt = $conn->prepare("DELETE FROM PROPERTY WHERE id = ?;");
$stmt->bind_param("i", $propertyId); // 'i' specifies the variable type => 'integer'

if (!$stmt->execute()) {
    echo "Error deleting property: " . $stmt->error;
    exit;
}

// Prepare the statement
$stmt = $conn->prepare("SELECT filename FROM PICTURE WHERE property_id = ?;");
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
$stmt = $conn->prepare("DELETE FROM PICTURE WHERE property_id = ?;");
$stmt->bind_param("i", $propertyId);
if (!$stmt->execute()) {
    echo "Error deleting pictures: " . $stmt->error;
}

// Close the statement
$stmt->close();

echo "Property deleted successfully";
