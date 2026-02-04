<?php
session_start();
include "db.php";

// Make sure ID is provided
if (!isset($_GET['id'])) {
    die("User ID not specified");
}

$id = $_GET['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? ''; // optional, leave blank to keep old password

    if ($username === '') {
        die("Username cannot be empty");
    }

    if ($password !== '') {
        // Hash the new password
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Update username + password
        $stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
        $stmt->bind_param("ssi", $username, $hashed, $id);
    } else {
        // Update username only
        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $username, $id);
    }

    if ($stmt->execute()) {
        header("Location: dashboard.php"); // or your users list page
        exit();
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch existing user data
$stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    die("User not found");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
<h2>Edit User</h2>

<form method="POST">
    <label>Username:</label><br>
    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required><br><br>

    <label>New Password (leave blank to keep old):</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Update User</button>
</form>

<a href="dashboard.php">Back</a>
</body>
</html>
