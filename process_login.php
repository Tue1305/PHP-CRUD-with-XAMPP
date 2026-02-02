<?php
	session_start();
	include "db.php";

	$username = $_POST['username'];
	$password = $_POST['password'];

	$sql = "SELECT * FROM users WHERE username = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("s", $username);
	$stmt->execute();

	$result = $stmt->get_result();

	if ($result->num_rows === 1 ){
		$user = $result->fetch_assoc();

		if (password_verify($password, $user['password'])){

			$_SESSION['username'] = $user['username'];
			
			header("Location: dashboard.php");
			exit();

		}else{
			echo "Invalid username or password";
		}
		
	}else {
    echo "Invalid username or password";
	}

?>

