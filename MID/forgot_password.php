<!DOCTYPE html>
<html>
  <head>
    <title>Tourist Management - Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <?php include('header.php'); ?>
    <div class="content">
      <h1>Forgot Password</h1>
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];

        $data = json_decode(file_get_contents('data.json'), true);

        $user = null;

        foreach ($data as $item) {
          if ($item['email'] === $email) {
            $user = $item;
            break;
          }
        }

        if ($user) {
          $new_password = bin2hex(random_bytes(5));

          $data = array_map(function($item) use ($email, $new_password) {
            if ($item['email'] === $email) {
              $item['password'] = password_hash($new_password, PASSWORD_DEFAULT);
            }
            return $item;
          }, $data);

          file_put_contents('data.json', json_encode($data));

          $to = $email;
          $subject = 'Password Reset';
          $message = 'Your new password is: ' . $new_password;
          $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

          if (mail($to, $subject, $message, $headers)) {
            echo '<p>New password sent to your email.</p>';
          } else {
            echo '<p>Failed to send email.</p>';
          }
        } else {
          echo '<p>Invalid email address.</p>';
        }
      }
      ?>
      <form method="POST">
        <div>
          <label for="email">Email:</label>
          <input type="email" name="email">
        </div>
        <button type="submit">Reset Password</button>
      </form>
    </div>
    <?php include('footer.php'); ?>
  </body>
</html>
