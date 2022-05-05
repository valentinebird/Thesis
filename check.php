<?php
$servername = "127.0.0.1";
$username = "thebwvas_SUPERUSER";
$password = "hiodtdMS1G";
$dbname = "thebwvas_THESIS";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id,username, email, reg_date FROM USER;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - Name: " . $row["username"]. " " . $row["email"] . " " . $row["reg_date"]. "<br>";
  }
} else {
  echo "0 results";
}
$conn->close();
?>