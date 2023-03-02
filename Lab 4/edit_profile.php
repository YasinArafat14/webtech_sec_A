<!DOCTYPE html>
<html>
<head>
	<title>Tourist Management System - Edit Profile</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<h1>Tourist Management System</h1>
	</header>
	<main>
		<h2>Edit Profile</h2>
		<form method="post" action="edit_profile.php" enctype="multipart/form-data">
			<?php if (isset($_GET['error'])): ?>
				<div class="error"><?php echo $_GET['error']; ?></div>
			<?php endif; ?>
			<?php if (isset($_GET['message'])): ?>
				<div class="message"><?php echo $_GET['message']; ?></div>
			<?php endif; ?>
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required>
			<label for="picture">Profile Picture:</label>
			<input type="file" id="picture" name="picture">
			<input type="submit" value="Save Changes">
		</form>
		<p><a href="profile.php">Back to Profile</a></p>
	</main>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = $_POST['name'];
	$picture = $user['picture'];

	// Check if a new profile picture was uploaded
	if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
		$picture = save_uploaded_picture($_FILES['picture']);
		if (!$picture) {
			header('Location: edit_profile.php?error=Error uploading profile picture');
			exit();
		}
	}

	// Update the user's profile and save the users list
	$user['name'] = $name;
	$user['picture'] = $picture;
	file_put_contents('users.txt', json_encode($users));

	header('Location: edit_profile.php?message=Changes saved');
	exit();
}

function save_uploaded_picture($file) {
	// Save the uploaded picture to the pictures directory
	$target_dir = 'pictures/';
	$target_file = $target_dir . basename($file['name']);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if the file is a valid image
$check = getimagesize($file['tmp_name']);
if (!$check) {
	return false;
}

// Generate a unique filename and save the file
$filename = uniqid() . '.' . $imageFileType;
$target_file = $target_dir . $filename;
if (!move_uploaded_file($file['tmp_name'], $target_file)) {
	return false;
}

return $target_file;
}
?>
