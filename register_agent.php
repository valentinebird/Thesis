<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "dbconfig.php";
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$con->set_charset("utf8mb4");

if (mysqli_connect_errno()) {
    exit('MySQL Connection Error: ' . mysqli_connect_error());
}

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