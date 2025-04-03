<?php
session_start(); // Start the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ApotheCare</title>
</head>
<body>
    <span>test</span>
    <?php if (isset($_SESSION['username'])): ?>
        <li><a href="settings.php">Settings</a></li>
        <li><a href="signout.php">Sign Out</a></li>
    <?php else: ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="signup.php">Sign up</a></li>
    <?php endif; ?>
</body>
</html>