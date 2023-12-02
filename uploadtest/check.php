<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "../dbconfig.php";
$db = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
mysqli_query($db, "SET NAMES utf8;");
if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM PICTURE ORDER BY upload_date DESC LIMIT 1;";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {

} else {
    echo "No results found.";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check</title>
</head>
<body>
<img src="<?php echo  $row["filename"] ?>" alt="<?php echo  $row["description"] ?>">

</body>
</html>

