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
$target_dir = "/home/thebwvas/madar-szakdolgozat.online/property_pics/";
if (isset($_FILES['fileToUpload']['name'][0])) {

    // Loop through each file
    foreach ($_FILES["fileToUpload"]["name"] as $key => $name) {
        $sanitized_property_name = preg_replace("/[^a-zA-Z0-9_-]/", "", $property_name);
        $imageFileType = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $newFileName = $sanitized_property_name . "_" . time() . "_" . $key . "." . $imageFileType;
        $target_file = $target_dir . $newFileName;

        $uploadOk = 1;

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$key]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"][$key] > 500000) {
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
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$key], $target_file)) {
                echo "The file " . htmlspecialchars($name) . " has been uploaded.";
                //$fullFilePath = $target_dir . $newFileName;
                $fullFilePath = "https://madar-szakdolgozat.online/property_pics/" . $newFileName;
                $sql = "INSERT INTO PICTURE (property_id, filename, description) VALUES ('$property_id', '$fullFilePath', '$property_name')";
                $result = mysqli_query($db, $sql);
                if (!$result) {
                    echo "Error: " . mysqli_error($db);
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

    }
} else {
    echo "No files were uploaded.";
}


?>
