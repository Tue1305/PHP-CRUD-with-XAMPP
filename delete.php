<?php
session_start();
include "db.php";

// Check if ID is provided
if (!isset($_GET['id'])) {
    die("User ID not specified");
}

$id = $_GET['id'];

// Optional: prevent deleting yourself if logged in
if (isset($_SESSION['username'])) {
    // Fetch username of the user being deleted
    $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
        die("User not found");
    }

    if ($user['username'] === $_SESSION['username']) {
        die("You cannot delete your own account while logged in.");
    }
}

// Prepare DELETE query
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: dashboard.php"); // or your users list page
    exit();
} else {
    echo "Error deleting user: " . $stmt->error;
}
?>
