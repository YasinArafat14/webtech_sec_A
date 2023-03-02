<!DOCTYPE html>
<html>
  <head>
    <title>Tourist Management - Change Password</title>
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

      if (isset($_POST['submit'])) {
        $user = $_SESSION['user'];
        $data = json_decode(file_get_contents('data.json'), true);

        foreach ($data as &$item) {
          if ($item['email'] === $user['email']) {
            if ($item['password'] !== md5($_POST['current_password'])) {
              echo '<p>Incorrect current password.</p>';
            } else if ($_POST['new_password'] !== $_POST['confirm_password']) {
              echo '<p>New password and confirm password do not match.</p>';
            } else {
              $item['password'] = md5($_POST['new_password']);
              file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT));
              echo '<p>Password changed successfully.</p>';
            }
          }
        }
      }
      ?>
      <h1>Change Password</h1>
      <form action="" method="post">
        <label for="current_password">Current Password:</label>
        <input type="password" name="current_password" id="current_password" required>
        <br>
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required>
        <br>
        <label for="confirm_password">Confirm New Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <br>
        <input type="submit" value="Submit" name="submit">
      </form>
    </div>
    <?php include('footer.php'); ?>
  </body>
</html>
