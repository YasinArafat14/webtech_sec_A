<!DOCTYPE html>
<html>
<head>
	<title>Tourist Management System - Change Password</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<h1>Tourist Management System</h1>
	</header>
	<main>
		<h2>Change Password</h2>
		<form method="post" action="change_password.php">
			<?php if (isset($_GET['error'])): ?>
				<div class="error"><?php echo $_GET['error']; ?></div>
			<?php endif; ?>
			<?php if (isset($_GET['message'])): ?>
				<div class="message"><?php echo $_GET['message']; ?></div>
			<?php endif; ?>
			<label for="old_password">Old Password:</label>
			<input type="password" id="old_password" name="old_password" required>
			<label for="new_password">New Password:</label>
			<input type="password" id="new_password" name="new_password" required>
			<label for="confirm_password">Confirm Password:</label>
			<input type="password" id="confirm_password" name="confirm_password" required>
			<input type="submit" value="Change Password">
		</form>
		<p><a href="profile.php">Back to Profile</a></p>
	</main>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$old_password = $_POST['old_password'];
	$new_password = $_POST['new_password'];
	$confirm_password = $_POST['confirm_password'];

	if ($old_password != $user['password']) {
		header('Location: change_password.php?error=Old password is incorrect');
		exit();
	}

	if ($new_password != $confirm_password) {
		header('Location: change_password.php?error=New password and confirm password do not match');
		exit();
	}

	// Update the user's password and save the users list
	$user['password'] = $new_password;
	file_put_contents('users.txt', json_encode($users));

	header('Location: change_password.php?message=Password changed');
	exit();
}
?>
