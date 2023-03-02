<!DOCTYPE html>
<html>
  <head>
    <title>Tourist Management - Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <?php include('header.php'); ?>
    <div class="content">
      <h1>Login</h1>
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $remember_me = isset($_POST['remember_me']) && $_POST['remember_me'] === 'on';
        $data = json_decode(file_get_contents('data.json'), true);
        

        $user = null;

        foreach ($data as $item) {
          if ($item['email'] === $email) {
            $user = $item;
            break;
          }
        }

        if ($user && password_verify($password, $user['password'])) {
          session_start();
          $_SESSION['user'] = $user;

          if ($remember_me) {
            setcookie('email', $email, time() + (86400 * 30), '/');
          }

          header('Location: dashboard.php');
          exit;
        } else {
          echo '<p>Invalid email or password.</p>';
        }
      }
      ?>
      <form method="POST">
        <div>
          <label for="email">Email:</label>
          <input type="email" name="email" value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>">
        </div>
        <div>
          <label for="password">Password:</label>
          <input type="password" name="password">
        </div>
        <div>
          <label for="remember_me">Remember me:</label>
          <input type="checkbox" name="remember_me">
        </div>
        <button type="submit">Log in</button>
      </form>
    </div>
    <?php include('footer.php'); ?>
  </body>
</html>
