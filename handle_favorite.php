<?php

session_start();
require "dbconfig.php";

if (isset($_POST['propertyId'], $_POST['action']) && isset($_SESSION['id'])) {
    $propertyId = $_POST['propertyId'];
    $userId = $_SESSION['id'];
    $action = $_POST['action'];

    // Connect to database
    // ... [Your database connection logic] ...

    // Fetch current favorite properties
    // ... [Fetch user's current favorite properties] ...

    // Add or remove the property ID from the favorites based on action
    if ($action === 'add') {
        // Add to favorites logic
        // ... [Check for duplicates and add] ...
    } else {
        // Remove from favorites logic
        // ... [Remove propertyId from the favorites list] ...
    }

    // Update the favorite properties in the database
    // ... [Update the database with the new list] ...

    $conn->close();
    echo "Favorite updated successfully";
}
else {
    echo "Invalid request";
}