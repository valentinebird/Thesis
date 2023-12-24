<?php
session_start();
require "dbconfig.php";
global $con;


if (!isset($_POST['username'], $_POST['password'])) {
    echo 'A felhasználónév vagy jelszó nincs kitöltve';
    exit();
}
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT username, password FROM USER WHERE username = ?')) {
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {

        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        //if (password_verify($_POST['password'], $password)) { hashed password
        //if ($_POST['password'] === $password) {
        if (password_verify($_POST['password'], $password)) {
            // Verification success! User has loggedin!
            // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.

            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            $_SESSION['is_agent'] = FALSE;
            echo $_SESSION['loggedin'];
            exit;
        } else {
            echo 'Hibás jelszó!';
            exit();
        }
    } else {
        echo 'Hibás felhasználónév!';
        exit();
    }
} else {
    echo 'Hibás lekérdezés!';
    exit();
}
?>