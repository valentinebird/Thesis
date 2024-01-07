<?php

session_start();
require "dbconfig.php";
require "profiledata.php";
global $con;

if (isset($_POST['propertyId'], $_POST['action']) && isset($_SESSION['id'])) {
    $propertyId = $_POST['propertyId'];
    $userId = $_SESSION['id'];
    $action = $_POST['action']; // 'add' or 'remove'

    if ($con->connect_error) {
        die("Nem lehet csatlakozni: " . $con->connect_error);
    }

    // Start transaction
    $con->begin_transaction();

    try {
        // Fetch current favorite properties
        $sql = "SELECT favorite_properties FROM USER WHERE username = '$userId'";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $favoriteProperties = json_decode($row["favorite_properties"], true);

            if ($action === 'add' && !in_array($propertyId, $favoriteProperties)) {
                $favoriteProperties[] = $propertyId;
            } elseif ($action === 'remove') {
                if (($key = array_search($propertyId, $favoriteProperties)) !== false) {
                    unset($favoriteProperties[$key]);
                }
            }

            $updatedFavorites = json_encode(array_values($favoriteProperties));
            $updateSql = "UPDATE USER SET favorite_properties = '$updatedFavorites' WHERE username = '$userId'";
            $con->query($updateSql);

            // Commit transaction
            $con->commit();

            echo $action === 'add' ? "Ingatlan a kedvencekhez adva. " : "Ingatlan eltávolítva a kedvencekből. ";
            echo "Sikeresen frissítve.";
        } else {
            echo "Nincs kedvenc ingatlanod, vagy a felhasználó nem létezik. Lépj be újra.";
        }
    } catch (Exception $e) {
        // Rollback transaction if something goes wrong
        $con->rollback();
        echo "Hiba történt: " . $e->getMessage();
    }

    $con->close();
} else {
    echo "Érvénytelen kérés";
}
?>
