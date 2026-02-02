<?php
	$conn = new mysqli("localhost", "root", "", "login_db");

	if ($conn->connect_error) {
		die("Connection Error". $conn->connect_error);
	}
?>

