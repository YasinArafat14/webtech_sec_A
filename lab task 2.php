<html>
  <head>
    <title>Form Validation</title>
  </head>
  <body>
    <?php
      $error = "";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
          $error = "Name is required";
        } else {
          $name = test_input($_POST["name"]);
          if (!preg_match("/^[a-zA-Z][a-zA-Z\s\.]*$/", $name)) {
            $error = "Name must start with a letter and contain only letters, periods and spaces";
          }
        }

        if (empty($_POST["email"])) {
          $error = "Email is required";
        } else {
          $email = test_input($_POST["email"]);
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format";
          }
        }

        if (empty($_POST["dob"])) {
          $error = "Date of birth is required";
        } else {
          $dob = test_input($_POST["dob"]);
          if (!preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/", $dob)) {
            $error = "Invalid date format (use dd/mm/yyyy)";
          } else {
            list($day, $month, $year) = explode("/", $dob);
            if (!checkdate($month, $day, $year)) {
              $error = "Invalid date";
            } else if ($year < 1953 || $year > 1998) {
              $error = "Year must be between 1953 and 1998";
            }
          }
        }

        if (empty($_POST["gender"])) {
          $error = "Gender is required";
        } else {
          $gender = test_input($_POST["gender"]);
        }
      }

      function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }
    ?>
    <h2>Form Validation</h2>
    <p><?php echo $error; ?></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      Name: <input type="text" name="name">
      <br><br>
      Email: <input type="text" name="email">
      <br><br>
      Date of birth: <input type="text" name="dob">
      <br><br>
      Gender:
      <input type="radio" name="gender" value="female">Female
      <input type="radio" name="gender" value="male">Male
      <br><br>
      <input type="submit" name="submit" value="Submit">
    </form>
  </body>
</html>
