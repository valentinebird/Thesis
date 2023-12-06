<?php

session_start();
// Change this to your connection info.
error_reporting(E_ALL);

require "dbconfig.php";
require "profiledata.php";
global $username;

// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Nem lehet a MySQL szerverhez csatlakozni: ' . mysqli_connect_error());
}

// Now we check if the data from the form was submitted
if (!isset($_POST['current_password'], $_POST['new_password'], $_POST['confirm_new_password'])) {
    echo 'A fenti mezők nincsenek kitöltve';
    exit();
}

if (!isset($_POST['current_password'], $_POST['new_password'], $_POST['confirm_new_password']) ||
    empty($_POST['current_password']) ||
    empty($_POST['new_password']) ||
    empty($_POST['confirm_new_password'])) {
    echo 'A fenti mezők nincsenek kitöltve';
    exit();
}

if ($_POST['new_password'] != $_POST['confirm_new_password']) {
    echo 'A két új jelszó nem egyezik meg!';
    exit();
}
if ($_POST['current_password'] == $_POST['new_password']) {
    echo 'A régi és az új jelszó nem lehet ugyanaz!';
    exit();
}


if ($_SESSION['is_agent']) {
    //Handle the user case
    if ($stmt = $con->prepare('SELECT password FROM AGENT WHERE username = ?')) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();

            if (password_verify($_POST['current_password'], $hashedPassword)) {
                $newPasswordHash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                $updateStmt = $con->prepare("UPDATE AGENT SET password = ? WHERE username = ?");
                $updateStmt->bind_param("ss", $newPasswordHash, $username);
                $updateStmt->execute();

                if ($updateStmt->affected_rows > 0) {
                    echo "Jelszó sikeresen le lett cserélve.";
                } else {
                    echo "Hiba a jelszócserével.";
                }
                $updateStmt->close();
            } else {
                echo 'A jelenlegi jelszó nem helyes!';
            }
        } else {
            echo 'Felhasználó nem található! Jelentkezz be újra!';
        }
        $stmt->close();
    } else {
        echo 'Adatbázis hiba.';
    }
} else {
    //Handle the user case
    if ($stmt = $con->prepare('SELECT password FROM USER WHERE username = ?')) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();

            if (password_verify($_POST['current_password'], $hashedPassword)) {
                $newPasswordHash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
                $updateStmt = $con->prepare("UPDATE USER SET password = ? WHERE username = ?");
                $updateStmt->bind_param("ss", $newPasswordHash, $username);
                $updateStmt->execute();

                if ($updateStmt->affected_rows > 0) {
                    echo "Jelszó sikeresen le lett cserélve.";
                } else {
                    echo "Hiba a jelszócserével.";
                }
                $updateStmt->close();
            } else {
                echo 'A jelenlegi jelszó nem helyes!';
            }
        } else {
            echo 'Felhasználó nem található! Jelentkezz be újra!';
        }
        $stmt->close();
    } else {
        echo 'Adatbázis hiba.';
    }

}

$con->close();
