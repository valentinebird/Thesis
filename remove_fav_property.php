<?php

session_start();
require "dbconfig.php";
global $con;

// Check if propertyId and userId are set
if (isset($_POST['propertyId']) && isset($_SESSION['id'])) {
    $propertyId = $_POST['propertyId'];
    $userId = $_SESSION['id'];

    // Start the transaction
    $con->begin_transaction();

    $sql = "SELECT favorite_properties FROM USER WHERE username = '$userId'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $favoriteProperties = json_decode($row["favorite_properties"], true);

        // Remove the property ID from the favorites
        if (($key = array_search($propertyId, $favoriteProperties)) !== false) {
            unset($favoriteProperties[$key]);
            $updatedFavorites = json_encode(array_values($favoriteProperties));
            // Corrected column name to 'username' in UPDATE query
            $updateSql = "UPDATE USER SET favorite_properties = '$updatedFavorites' WHERE username = '$userId'";

            if ($con->query($updateSql) === TRUE) {
                // Commit the transaction
                $con->commit();
                echo "A kedvenc sikeresen el lett távolítva";
            } else {
                // Rollback the transaction in case of error
                $con->rollback();
                echo "Hiba: " . $con->error;
            }
        } else {
            echo "Nem található a kedvenc ingatlan";
        }
    } else {
        echo "Nincsennek kedvenc ingatlanjaid vagy a felhasználó nem található";
    }

    $con->close();
} else {
    echo "Érvénytelen kérés"; // "Invalid request" in Hungarian
}

?>
