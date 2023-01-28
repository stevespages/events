<?php
  session_start();
  require_once '../php/error-reporting.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <title>User</title>
  </head>
  <body>
    <header>
<?php
  if (empty($_SESSION['user'])){
    echo "<p><a href='../authentication/login/'>Login</a> or ";
    echo "<a href='../authentication/register/'>Register</a></p>";
  } else {
    echo "<p>";
    echo "Hallo ".$_SESSION['user'];
    echo " | <a href='../authentication/logout/'>Logout</a>";
    echo " | <a href='../authentication/close-account/'>Close Account</a>";
    echo "</p>";
  }
?>
    </header>
  </body>
</html>
