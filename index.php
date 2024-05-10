<?php
session_start();

if (isset($_SESSION['error_message'])) {
    echo "<script>alert('Credenziali errate. Login fallito!');</script>";
    unset($_SESSION['error_message']); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/asset/css/style_index.css">
    <link rel="icon" href="../asset/img/aws_logo.png" type="image/x-icon">
</head>
<body>
    <div id="login-box">
        <h2>Login</h2>
        <form method="post" action="/includes/login.php">
            <input type="text" name="username" maxlength="30" placeholder="Username" required>
            <input type="password" name="password" minlength="8" maxlength="16" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>