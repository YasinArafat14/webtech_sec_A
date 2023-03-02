<!DOCTYPE html>
<html>
  <head>
    <title>Tourist Management - View Profile</title>
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

      foreach ($data as $item) {
        if ($item['email'] === $user['email']) {
          $user_data = $item;
          break;
        }
      }
      ?>
      <h1>View Profile</h1>
      <p>Name: <?php echo $user_data['name']; ?></p>
      <p>Email: <?php echo $user_data['email']; ?></p>
      <!-- Add other relevant fields here -->
    </div>
    <?php include('footer.php'); ?>
  </body>
</html>
