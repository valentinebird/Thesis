<?php
echo "alma";

require "../dbconfig.php";

/*
$mysqli = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$userPassword = 'admin';
$hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

$stmt = $mysqli->prepare("UPDATE AGENT SET password = ? WHERE username = ?");

$username = 'admin';
$stmt->bind_param("ss", $hashedPassword, $username );

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();

echo "vege";
*/

// See the password_hash() example to see where this came from.
$hash = '$2y$10$fYlY8IsbMdeGqHJ.Y6wnS.MqpWMlxrFQwnyMnwl6IUzfBSIkAQH4S';

if (password_verify('admin', $hash)) {
    echo 'Password is valid!';
} else {
    echo 'Invalid password.';
}
?>