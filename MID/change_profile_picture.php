<!DOCTYPE html>
<html>
  <head>
    <title>Tourist Management - Change Profile Picture</title>
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
        $target_dir = 'uploads/';
        $target_file = $target_dir . basename($_FILES['profile_picture']['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
          $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
          if($check !== false) {
            $uploadOk = 1;
          } else {
            echo "<p>File is not an image.</p>";
            $uploadOk = 0;
          }
        }

        // Check file size
        if ($_FILES["profile_picture"]["size"] > 500000) {
          echo "<p>Sorry, your file is too large.</p>";
          $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
          echo "<p>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
          $uploadOk = 0;
        }

        if ($uploadOk == 1) {
          if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $user = $_SESSION['user'];
            $data = json_decode(file_get_contents('data.json'), true);

            foreach ($data as &$item) {
              if ($item['email'] === $user['email']) {
                $item['profile_picture'] = $target_file;
              }
            }

            file_put_contents('data.json', json_encode($data, JSON_PRETTY_PRINT));

            echo "<p>The file ". htmlspecialchars( basename( $_FILES["profile_picture"]["name"])). " has been uploaded.</p>";
          } else {
            echo "<p>Sorry, there was an error uploading your file.</p>";
          }
        }
      }
      ?>
      <h1>Change Profile Picture</h1>
      <form action="" method="post" enctype="multipart/form-data">
        <label for="profile_picture">Select image to upload:</label>
        <input type="file" name="profile_picture" id="profile_picture">
        <input type="submit" value="Upload Image" name="submit">
      </form>
    </div>
    <?php include('footer.php'); ?>
  </body>
</html>
