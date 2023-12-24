<?php

require "dbconfig.php";
global $con;

if (!isset($_POST['username'], $_POST['password'],$_POST['password_re'], $_POST['email'])) {
    exit('Tölts ki minden adatot!');
}

if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password_re']) || empty($_POST['email'])) {
    exit('Tölts ki minden mezőt, valamelyik mező nincs kitöltve!');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    exit('E-mail cím nem megfelelő!');
}
// Username must contain only characters and numbers.
if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0) {
    exit('Felahsználó név nem megfelelő');
}

const minimumPasswordLength = 3;
const maxPasswordLength = 20;
if (strlen($_POST['password']) > maxPasswordLength || strlen($_POST['password']) < minimumPasswordLength) {
    exit('A jelszó minimum '.minimumPasswordLength . " és " . maxPasswordLength . "!");
}

if ($_POST['password'] === $_POST['password_re'] ) {
    exit('A két jelszó nem egyezik meg!');
}
// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id, password FROM USER WHERE username = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
    // Store the result so we can check if the account exists in the database.
    if ($stmt->num_rows > 0) {
        // Username already exists
        echo 'A felhasználó név már létezik használj másikat!';
    } else {
        // Username doesnt exists, insert new account
        if ($stmt = $con->prepare('INSERT INTO USER (username,  email, password) VALUES (?, ?, ?)')) {
            // We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $_POST['username'],  $_POST['email'], $password);
            $stmt->execute();
            echo 'Sikeres regisztráció<br><a href="index.php"></a>';
        } else {
            // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
            echo 'Hiba a regisztráció közben!';
        }
    }
} else {
    // Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
    echo 'MySQL regisztrációs hiba!';
}

?>