<?php
include "config.php";
if($_POST['username'] == '' || $_POST['password'] == ''){
  foreach ($_POST as $key => $value) {
      echo "<li>Please Enter ".$key.".</li>";
  }
  exit();
}
$userName = mysqli_real_escape_string($con,$_POST['username']);
$password = mysqli_real_escape_string($con,$_POST['password']);

$sql_query = "select * from USER where username='".$userName."' and password='".$password."'";
$result = mysqli_query($con,$sql_query);
$row = mysqli_fetch_array($result);
if($row){
    echo "<b>Your Details:</b><br/>".$row['username']."<br/>".$row['name'];
    exit();
}else{
    echo "<li>Invlid Username or password.</li>";
    exit();
}