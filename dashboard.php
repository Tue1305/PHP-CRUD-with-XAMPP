<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch all users
$result = $conn->query("SELECT id, username, create_at FROM users ORDER BY create_at DESC");
if (!$result) {
    die("Database query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Users</title>
</head>
<body>
    <h1>Welcome, <?php echo ($_SESSION['username']); ?> (READ-ONLY)</h1>
    <button type="button" onclick="location.href='logout.php'">Logout</button>

    <h2>All Users</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php while ($user = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo $user['create_at']; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $user['id']; ?>">Edit</a> |
                    <a href="delete.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Delete this user?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
