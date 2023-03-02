<!DOCTYPE html>
<html>
<head>
	<title>Tourist Management System - Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<h1>Tourist Management System</h1>
	</header>
	<main>
		<h2>Login</h2>
		<form method="post" action="login.php">
			<?php if (isset($_GET['error'])): ?>
				<div class="error"><?php echo $_GET['error']; ?></div>
			<?php endif; ?>
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" required>
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" required>
			<input type="submit" value="Login">
		</form>
		<div>
			Don't have an account? <a href="register.php">Register</a>
		</div>
		<div>
			<a href="forgot_password.php">Forgot Password?</a>
		</div>
	</main>
</body>
</html>
