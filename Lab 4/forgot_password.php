<!DOCTYPE html>
<html>
<head>
	<title>Tourist Management System - Forgot Password</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<h1>Tourist Management System</h1>
	</header>
	<main>
		<h2>Forgot Password</h2>
		<form method="post" action="forgot_password.php">
			<?php if (isset($_GET['error'])): ?>
				<div class="error"><?php echo $_GET['error']; ?></div>
			<?php endif; ?>
			<?php if (isset($_GET['message'])): ?>
				<div class="message"><?php echo $_GET['message']; ?></div>
			<?php endif; ?>
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" required>
			<input type="submit" value="Reset Password">
		</form>
		<p><a href="index.php">Back to Login</a></p>
	</main>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$email = $_POST['email'];

	// Check if the email is registered
	$user = null;
	foreach ($users as $u) {
		if ($u['email'] == $email) {
			$user = $u;
			break;
		}
	}
	if (!$user) {
		header('Location: forgot_password.php?error=Email is not registered');
		exit();
	}

	// Generate a new password
	$new_password = uniqid();

	// Send the new password to the user's email
	$headers = "From: Tourist Management System <noreply@example.com>\r\n";
	$headers .= "Reply-To: Tourist Management System <noreply@example.com>\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$subject = "Tourist Management System - Password Reset";
	$message = "Hello, " . $user['name'] . "! Your new password is: " . $new_password;
	if (mail($email, $subject, $message, $headers)) {
		// Update the user's password and save the users list
		$user['password'] = $new_password;
		file_put_contents('users.txt', json_encode($users));

		header('Location: forgot_password.php?message=Check your email for the new password');
		exit();
	} else {
		header('Location: forgot_password.php?error=Failed to send email');
		exit();
	}
}
?>
