<?php
require "dbconfig.php";
global $con;

// Validation
if (empty($_POST['username']) || empty($_POST['real_name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['password_re']) || empty($_POST['work_title']) || empty($_POST['description'])) {
    exit('Kérjük, töltse ki az összes mezőt.');
}

if ($_POST['password'] !== $_POST['password_re']) {
    exit('A jelszavak nem egyeznek.');
}

// Prepare your INSERT statement
if ($stmt = $con->prepare('INSERT INTO AGENT (username, real_name, email, phone, password, work_title, description, is_admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)')) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt->bind_param('sssssssi', $_POST['username'], $_POST['real_name'], $_POST['email'], $_POST['phone'], $password, $_POST['work_title'], $_POST['description'], $_POST['is_admin']);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        echo '1'; // Success
    } else {
        echo 'Regisztrációs hiba történt.';
    }
} else {
    echo 'SQL hiba.';
}

$con->close();

?>