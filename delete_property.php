<?php

session_start();
require "dbconfig.php";

$propertyId = $_POST['id']; // Use POST instead of GET

$conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$propertyId = $_GET['id'];

// Delete property from PROPERTY table
$sql = "DELETE FROM PROPERTY WHERE id = $propertyId";
if (!$conn->query($sql)) {
    echo "'Error deleting property: ' . $conn->error";
    die('Error deleting property: ' . $conn->error);

}

// Find related entries in PICTURE table
$sql = "SELECT filename FROM PICTURE WHERE property_id = $propertyId";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    // Remove files from server
    unlink($row['filename']);
}

// Delete entries from PICTURE table
$sql = "DELETE FROM PICTURE WHERE property_id = $propertyId";
if (!$conn->query($sql)) {
    echo "Error deleting pictures: ' . $conn->error";
    die('Error deleting pictures: ' . $conn->error);
}

$conn->close();
echo json_encode(["status" => "success", "message" => "Az ingatlan sikeresen ki lett törölve."]);
header('Location: my-properties.php'); // Redirect back to the properties page
exit;


