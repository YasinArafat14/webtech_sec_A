<!DOCTYPE html>
<html>
  <head>
    <title>Tourist Management - Dashboard</title>
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
      ?>
      <h1>Dashboard - Welcome <?php echo $user_data['name']; ?></h1>
      <p>Your Email: <?php echo $user_data['email']; ?></p>
      <p>Your Password: <?php echo $user_data['password']; ?></p>
      <!-- Display other relevant data here -->
    </div>
    <?php include('footer.php'); ?>
  </body>
</html>
