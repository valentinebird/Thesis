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

if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0) {
    exit('Felhasználó név nem megfelelő');
}

const maxUsernameLength = 30;
const maxEmailLength = 150;

// ... previous code ...

if (strlen($_POST['username']) > maxUsernameLength) {
    exit('A felhasználónév nem lehet hosszabb, mint ' . maxUsernameLength . ' karakter!');
}

if (strlen($_POST['email']) > maxEmailLength) {
    exit('Az e-mail cím nem lehet hosszabb, mint ' . maxEmailLength . ' karakter!');
}

const minimumPasswordLength = 3;
const maxPasswordLength = 20;
if (strlen($_POST['password']) > maxPasswordLength || strlen($_POST['password']) < minimumPasswordLength) {
    exit('A jelszó minimum '.minimumPasswordLength . " és " . maxPasswordLength . "!");
}

if ($_POST['password'] !== $_POST['password_re']) {
    exit('A két jelszó nem egyezik meg!');
}

// Start the transaction
$con->begin_transaction();

if ($stmt = $con->prepare('SELECT id, password FROM USER WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Username already exists
        $con->rollback(); // Rollback transaction
        echo 'A felhasználó név már létezik használj másikat!';
    } else {
        if ($stmt = $con->prepare('INSERT INTO USER (username, email, password) VALUES (?, ?, ?)')) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $_POST['username'], $_POST['email'], $password);
            $stmt->execute();
            $con->commit(); // Commit the transaction
            echo 'Sikeres regisztráció<br><a href="index.php"></a>';
        } else {
            $con->rollback(); // Rollback transaction
            echo 'Hiba a regisztráció közben!';
        }
    }
} else {
    $con->rollback(); // Rollback transaction
    echo 'Adatbázis regisztrációs hiba!';
}

$con->close();
?>
