<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = ($_POST["username"]);
    $password = ($_POST["password"]);

    if (empty($username) || empty($password)) {
        die("All fields are required!");
    }

    // Prepare SQL (SECURE)
    $stmt = $conn->prepare(
        "INSERT INTO users (username, password) VALUES (?, ?)"
    );

    // Bind values
    $stmt->bind_param("ss", $username, $password);

    // Execute
    $stmt->execute();

    echo "Account created!";
    
}