<?php

//This code is getting all the data from the database wheather you are AGENT or you are USER.
session_start();
require "dbconfig.php";
global $con;

$username = $_SESSION['username'];
if ($_SESSION['is_agent']) {
    $sql = "SELECT * FROM AGENT WHERE username = '$username ';";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $id = $row["id"];
        $username = $row["username"];
        $real_name = $row["real_name"];
        $email = $row["email"];
        $phone = $row["phone"];
        $password = $row["password"];
        $work_title = $row["work_title"];
        $description = $row["description"];
        $is_admin = $row["is_admin"];
        $reg_date = $row["reg_date"];

    } else {
        echo "Adatbázis hiba";
    }
} else {
    $sql = "SELECT * FROM USER WHERE username = '$username ';";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $id = $row["id"];
        $username = $row["username"];
        $email = $row["email"];
        $password = $row["password"];
        $favorite_properties = $row["favorite_properties"];
        $reg_date = $row["reg_date"];

    } else {
        echo "Adatbázis hiba";
    }

}
?>