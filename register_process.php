<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = ($_POST["username"]);
    $password = ($_POST["password"]);

    if (empty($username) || empty($password)) {
        die("All fields are required!");
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL (SECURE)
    $stmt = $conn->prepare(
        "INSERT INTO users (username, password) VALUES (?, ?)"
    );

    // Bind values
    $stmt->bind_param("ss", $username, $hashed);

    // Execute
    if ($stmt->execute()) {
        // Set session and redirect to dashboard
        session_regenerate_id(true);
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    }else {
        echo "Error creating account: " . $stmt->error;
    }
    
}