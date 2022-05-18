<?php
session_start();
$host =  "127.0.0.1";
$user = "thebwvas_SUPERUSER";
$password = "hiodtdMS1G";
$dbname = "thebwvas_THESIS";

$con = mysqli_connect($host, $user, $password,$dbname);
// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}