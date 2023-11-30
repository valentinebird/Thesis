<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "../dbconfig.php";
// select the latest added property
$db = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT id FROM PROPERTY ORDER BY upload_date DESC LIMIT 1;";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
echo $row["id"]

?>