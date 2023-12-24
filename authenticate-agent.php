<?php
session_start();

require "dbconfig.php";
global $con;



if (!isset($_POST['username'], $_POST['password'])) {
    echo 'A felhasználónév vagy jelszó nincs kitöltve';
    exit();
}
// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT username, password FROM AGENT WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();
	// If the username exists
	if ($stmt->num_rows > 0) {

		$stmt->bind_result($id, $password);
		$stmt->fetch();
		// Account exists, now we verify the password.
		// Note: remember to use password_hash in your registration file to store the hashed passwords.
        //if (password_verify($_POST['password'], $password)) { hashed password
		if (password_verify($_POST['password'], $password)) {
            session_regenerate_id();
			$_SESSION['loggedin'] = TRUE;
			$_SESSION['name'] = $_POST['username'];
			$_SESSION['id'] = $id;
			$_SESSION['is_agent'] = TRUE;
            echo $_SESSION['loggedin'];
            exit;
		} else {
			echo 'Hibás jelszó!';
            exit();
		}
	} else {
		echo 'Hibás felhasználónév!';
        exit();
	}
} else {
	echo 'Hibás lekérdezés!';
    exit();
}
?>

