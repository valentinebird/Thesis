<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "../dbconfig.php";

// select the latest added property
$db = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
mysqli_query($db, "SET NAMES utf8;");
if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, property_name FROM PROPERTY ORDER BY upload_date DESC LIMIT 1;";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $property_id = $row["id"];
    $property_name = $row["property_name"];
} else {
    echo "No results found.";
}
$sanitized_property_name = preg_replace("/[^a-zA-Z0-9_-]/", "", $property_name);

$target_dir = "/home/thebwvas/madar-szakdolgozat.online/property_pics/";
//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

// Sanitize the property name to be safe as a file name
$sanitized_property_name = preg_replace("/[^a-zA-Z0-9_-]/", "", $property_name);
// Get the file extension
$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
// Construct the new file name
$newFileName = $sanitized_property_name . "." . $imageFileType;
// Set the target file with the new file name
$target_file = $target_dir . $newFileName;






$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$uploadOk = 1;

// Check if image file is an actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";

        $sql = "INSERT INTO PICTURE (property_id, filename, description) VALUES ('$property_id', '$target_file', '$property_name')";
        $result = mysqli_query($db, $sql);
        $info_message = "Sikeres feltöltés" . mysqli_error($db);
        //header('Location: index.html');
        //exit();


    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
