<?php

  // This page would be used for multi user usage of Events.

  // Users are redirected here from pages when $_SESSION['user'] undefined.

  // When Events is used within another website which has authentication...
  // ...this page is not required. Instead they should be redirected to...
  // ...the home page of the containing website when $_SESSION['user']...
  // ...is undefined for logging in there.

  // The page to which users should be redirected when $_SESSION['user']...
  // ...is not defined is defined in events/config.php and is the name...
  // ...of that variable is $loginRedirectURL

  require_once './php/error-reporting.php';

  require_once './config.php';

  session_start();

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
