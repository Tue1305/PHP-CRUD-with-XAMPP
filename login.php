<!DOCTYPE html>
<html>
<head>
    <title>LOG IN</title>
</head>
<body>
    <h2>Log in</h2>
    <form method="post" action="process_login.php">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
		<button type="button" onclick="location.href='register.php'">Resigter</button>
    </form>
</body>
</html>