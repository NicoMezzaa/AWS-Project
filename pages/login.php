<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="stylesheet" href="../asset/css/style_login.css">
	<link rel="icon" href="../asset/img/aws_logo.png" type="image/x-icon">
</head>

<body>
	<?php

	if (isset($_SESSION['error_message'])) {
		echo "<script>alert('Credenziali errate. Login fallito!');</script>";
		unset($_SESSION['error_message']);
	}
	?>
	<div class="login-box">
		<h1>Login</h1>
		<form method="post" action="../includes/login.php">
			<input type="text" placeholder="Username" maxlength="30" name="username" id="login-input1" require>
			<input type="password" placeholder="Password" minlength="8" maxlength="16" name="password" id="login-input2" required>
			<button type="submit" id="login-button">Login</button>
		</form>
	</div>

	<div class="theme-toggle">
		<h2></h2>
		<label class="switch">
			<input type="checkbox" onclick="switchTheme()">
			<span class="slider"></span>
		</label>
	</div>
	<script src="../asset/js/login.js"></script>
</body>

</html>