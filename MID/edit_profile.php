<!DOCTYPE html>
<html>
  <head>
    <title>Tourist Management - Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <?php include('header.php'); ?>
    <div class="content">
      <?php
      session_start();

      if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit;
      }

      $user = $_SESSION['user'];
      $data = json_decode(file_get_contents('data.json'), true);
      $user_data = null;

      foreach ($data as $item) {
        if ($item['email'] === $user['email']) {
          $user_data = $item;
          break;
        }
      }

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_data['name'] = $_POST['name'];
        $user_data['email'] = $_POST['email'];
        $user_data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        // Update other relevant fields

        $data = array_map(function($item) use ($user_data) {
          if ($item['email'] === $user_data['email']) {
            $item = $user_data;
          }
          return $item;
        }, $data);

        file_put_contents('data.json', json_encode($data));

        $_SESSION['user'] = $user_data;

        header('Location: view_profile.php');
        exit;
      }
      ?>
      <h1>Edit Profile</h1>
      <form method="POST" action="edit_profile.php">
        <div>
          <label for="name">Name:</label>
          <input type="text" name="name" value="<?php echo $user_data['name']; ?>">
        </div>
        <div>
          <label for="email">Email:</label>
          <input type="email" name="email" value="<?php echo $user_data['email']; ?>">
        </div>
        <div>
          <label for="password">Password:</label>
          <input type="password" name="password">
        </div>
        <!-- Add other relevant fields here -->
        <button type="submit">Update Profile</button>
      </form>
    </div>
    <?php include('footer.php'); ?>
  </body>
</html>
