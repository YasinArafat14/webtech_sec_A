<!DOCTYPE html>
<html>
  <head>
    <title>Tourist Management - Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <?php include('header.php'); ?>
    <div class="content">
      <h1>Registration</h1>
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        $errors = [];

        if (empty($name)) {
          $errors['name'] = 'Name is required';
        }

        if (empty($email)) {
          $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $errors['email'] = 'Invalid email format';
        }

        if (empty($password)) {
          $errors['password'] = 'Password is required';
        } elseif (strlen($password) < 6) {
          $errors['password'] = 'Password should be at least 6 characters';
        }

        if ($password !== $confirm_password) {
          $errors['confirm_password'] = 'Passwords do not match';
        }

        if (empty($errors)) {
          $data = [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
          ];

          $json_data = json_encode($data);

          file_put_contents('data.json', $json_data);

          echo '<p>Registration successful. Please log in.</p>';
        } else {
          echo '<ul>';
          foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
          }
          echo '</ul>';
        }
      }
      ?>
      <form method="POST">
        <div>
          <label for="name">Name:</label>
          <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
        </div>
        <div>
          <label for="email">Email:</label>
          <input type="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
        </div>
        <div>
          <label for="password">Password:</label>
          <input type="password" name="password">
        </div>
        <div>
          <label for="confirm_password">Confirm Password:</label>
          <input type="password" name="confirm_password">
        </div>
        <button type="submit">Register</button>
      </form>
    </div>
    <?php include('footer.php'); ?>
  </body>
</html>
