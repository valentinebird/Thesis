<?php
$DATABASE_HOST =  "127.0.0.1";
$DATABASE_USER = "thebwvas_SUPERUSER";
$DATABASE_PASS = "hiodtdMS1G";
$DATABASE_NAME = "thebwvas_THESIS";

global $DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME, $id;
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$con->set_charset("utf8mb4");

if (mysqli_connect_errno()) {
    exit('Nem lehet a MySQL szerverhez csatlakozni: ' . mysqli_connect_error());
}

if ($con->connect_error) {
    die("Hiba a csatlakozáskor: " . $con->connect_error);
}
?>