<!DOCTYPE html>
<html>
<head>
	<title>Tourist Management System - Register</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<h1>Tourist Management System</h1>
	</header>
	<main>
		<h2>Register</h2>
		<form method="post" action="register.php">
			<?php if ($error_message): ?>
				<div class="error"><?php echo $error_message; ?></div>
			<?php endif; ?>
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
			<label for="password">Password:</label>
			<input type="password" id="password" name="password" required>
			<label for="confirm_password">Confirm Password:</label>
			<input type="password" id="confirm_password" name="confirm_password" required>
			<input type="submit" value="Register">
		</form>
		<div>
			Already have an account? <a href="index.php">Login</a>
		</div>
	</main>
</body>
</html>

<?php
$error_message = null;
$name = null;
$email = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];

	// Validate input
	if ($password != $confirm_password) {
		$error_message = "Passwords do not match";
	} else {
		// Check if email is already taken by another user
		$users = get_users();
		foreach ($users as $user) {
			if ($user['email'] == $email) {
				$error_message = "Email already taken by another user";
				break;
			}
		}
		if (!$error_message) {
			// Hash the password
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);

			// Create the user object
			$user = [
				'name' => $name,
				'email' => $email,
				'password' => $hashed_password
			];

			// Add the user to the users list
			$users[] = $user;

			// Save the users list to the users file
			file_put_contents('users.txt', json_encode($users));

			// Set the session and redirect to the profile page
			$_SESSION['email'] = $email;
			header('Location: profile.php');
			exit();
		}
	}
}

function get_users() {
	// Get the users from the users file
	$users_json = file_get_contents('users.txt');
	$users = json_decode($users_json, true);
	if (!$users) {
		$users = [];
	}
	return $users;
}
