<!DOCTYPE html>
<html>
<head>
	<title>Tourist Management System - Profile</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<h1>Tourist Management System</h1>
	</header>
	<main>
		<h2>Profile</h2>
		<?php if (isset($_SESSION['email'])): ?>
			<p>Name: <?php echo $user['name']; ?></p>
			<p>Email: <?php echo $user['email']; ?></p>
			<p>
				Profile Picture:
				<img src="<?php echo $user['picture']; ?>" alt="Profile Picture">
			</p>
			<p>
				<a href="edit_profile.php">Edit Profile</a>
				<a href="change_password.php">Change Password</a>
			</p>
			<form method="post" action="logout.php">
				<input type="submit" value="Logout">
			</form>
		<?php else: ?>
			<p>You are not logged in. <a href="index.php">Login</a> or <a href="register.php">Register</a></p>
		<?php endif; ?>
	</main>
</body>
</html>
