<?php

session_start();
require "dbconfig.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if propertyId, action, and userId are set
if (isset($_POST['propertyId'], $_POST['action']) && isset($_SESSION['id'])) {
    $propertyId = $_POST['propertyId'];
    $userId = $_SESSION['id'];
    $action = $_POST['action']; // 'add' or 'remove'

    echo "Property ID: " . $propertyId . "<br>";
    echo "User ID: " . $userId . "<br>";
    echo "Action: " . $action . "<br>";

    $conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $conn->set_charset("utf8mb4");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch current favorite properties
    $sql = "SELECT favorite_properties FROM USER WHERE username = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $favoriteProperties = json_decode($row["favorite_properties"], true);

        if ($action === 'add') {
            // Add the property ID to the favorites if not already present
            if (!in_array($propertyId, $favoriteProperties)) {
                $favoriteProperties[] = $propertyId;
                echo "Property added to favorites. ";
            }
        } elseif ($action === 'remove') {
            // Remove the property ID from the favorites
            if (($key = array_search($propertyId, $favoriteProperties)) !== false) {
                unset($favoriteProperties[$key]);
                echo "Property removed from favorites. ";
            }
        }

        $updatedFavorites = json_encode(array_values($favoriteProperties));
        $updateSql = "UPDATE USER SET favorite_properties = '$updatedFavorites' WHERE username = '$userId'";

        if ($conn->query($updateSql) === TRUE) {
            echo "Favorite properties updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "No favorites found or user not found";
    }

    $conn->close();
} else {
    echo "Érvénytelen kérés"; // "Invalid request" in Hungarian
}
?>
