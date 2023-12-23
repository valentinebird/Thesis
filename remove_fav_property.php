<?php

session_start();
require "dbconfig.php";


// Check if propertyId and userId are set
if (isset($_POST['propertyId']) && isset($_SESSION['id'])) {
    $propertyId = $_POST['propertyId'];
    $userId = $_SESSION['id'];

    // Echo for debugging
    echo "Property ID: " . $propertyId . "<br>";
    echo "User ID: " . $userId . "<br>";

    $conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    $conn->set_charset("utf8mb4");

    if ($conn->connect_error) {
        die("Az adatbázishoz nem lehet csatlakozni: " . $conn->connect_error);
    }

    // Fetch current favorite properties
    // Corrected column name to 'username'
    $sql = "SELECT favorite_properties FROM USER WHERE username = '$userId'";
    $result = $conn->query($sql);



    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $favoriteProperties = json_decode($row["favorite_properties"], true);

        // Remove the property ID from the favorites
        if (($key = array_search($propertyId, $favoriteProperties)) !== false) {
            unset($favoriteProperties[$key]);
            $updatedFavorites = json_encode(array_values($favoriteProperties));
            // Corrected column name to 'username' in UPDATE query
            $updateSql = "UPDATE USER SET favorite_properties = '$updatedFavorites' WHERE username = '$userId'";

            if ($conn->query($updateSql) === TRUE) {
                echo "A kedvenc sikeresen el lett távolítva";
            } else {
                echo "Hiba: " . $conn->error;
            }
        } else {
            echo "Nem található a kedvenc ingatlan";
        }
    } else {
        echo "Nincsennek kedvenc ingatlanjaid vagy a felhasználó nem található";
    }

    $conn->close();
} else {
    echo "Érvénytelen kérés"; // "Invalid request" in Hungarian
}

?>
