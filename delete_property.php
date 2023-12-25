<?php
require "dbconfig.php";
global $con;

$propertyId = $_POST['id'] ?? null; // Using null coalescing operator
if (!isset($propertyId) || !is_numeric($propertyId)) {
    echo "Az ingatlan id nem megfelelő!";
    exit;
}

// Deleting pictures associated with the property
$stmt = $con->prepare("SELECT filename FROM PICTURE WHERE property_id = ?");
$stmt->bind_param("i", $propertyId);
$stmt->execute();
$stmt->bind_result($filename);

while ($stmt->fetch()) {
    if (file_exists($filename)) {
        unlink($filename);
    }
}
$stmt->close(); // Close the statement

// Deleting entries from PICTURE table
$stmt = $con->prepare("DELETE FROM PICTURE WHERE property_id = ?");
$stmt->bind_param("i", $propertyId);
if (!$stmt->execute()) {
    echo "Hiba a kép törlésekor: " . $stmt->error;
    $stmt->close();
    exit;
}
$stmt->close(); // Close the statement

// Deleting the property
$stmt = $con->prepare("DELETE FROM PROPERTY WHERE id = ?");
$stmt->bind_param("i", $propertyId);
if ($stmt->execute()) {
    echo "Ingatlan sikeresen törölve.";
} else {
    echo "Hiba az ingatlant törlésekor: " . $stmt->error;
}
$stmt->close(); // Close the statement
?>