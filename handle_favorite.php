<?php

session_start();
require "dbconfig.php";
global $con;

// Check if propertyId, action, and userId are set
if (isset($_POST['propertyId'], $_POST['action']) && isset($_SESSION['id'])) {
    $propertyId = $_POST['propertyId'];
    $userId = $_SESSION['id'];
    $action = $_POST['action']; // 'add' or 'remove'

    if ($con->connect_error) {
        die("Nem lehet csatlakozni: " . $con->connect_error);
    }

    // Fetch current favorite properties
    $sql = "SELECT favorite_properties FROM USER WHERE username = '$userId'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $favoriteProperties = json_decode($row["favorite_properties"], true);

        if ($action === 'add') {
            // Add the property ID to the favorites if not already present
            if (!in_array($propertyId, $favoriteProperties)) {
                $favoriteProperties[] = $propertyId;
                echo "Ingatlan a kedvencekhez adva. ";
            }
        } elseif ($action === 'remove') {
            // Remove the property ID from the favorites
            if (($key = array_search($propertyId, $favoriteProperties)) !== false) {
                unset($favoriteProperties[$key]);
                echo "Ingatlan eltávolítva a kedvencekből. ";
            }
        }

        $updatedFavorites = json_encode(array_values($favoriteProperties));
        $updateSql = "UPDATE USER SET favorite_properties = '$updatedFavorites' WHERE username = '$userId'";

        if ($con->query($updateSql) === TRUE) {
            echo "Sikeresen frissítve.";
        } else {
            echo "A rekordot nem lehet frissíteni: " . $con->error;
        }
    } else {
        echo "Nincs kedvenc ingatlanod, vagy a felhasználó nem létezik. Lépj be újra.";
    }

    $con->close();
} else {
    echo "Érvénytelen kérés";
}
?>
