<?php
  session_start();
  require_once './php/error-reporting.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/main.css" rel="stylesheet">
    <script type="module" src="./main.js"></script>
    <title>Month</title>
  </head>
  <body>
  <header>
<?php
  if (empty($_SESSION['user'])){
    echo "<p><a href='./authentication/login/'>Login</a> or ";
    echo "<a href='./authentication/register/'>Register</a></p>";
  } else {
    echo "<p>";
    echo "Hallo ".$_SESSION['user'];
    echo " | <a href='./authentication/logout/'>Logout</a>";
    echo " | <a href='./authentication/close-account/'>Close Account</a>";
    echo "</p>";

    require_once './php/Events.php';
    require_once './php/Calendar.php';
    require_once './php/functions.php';
    require_once './php/cal-demo.php';
    require_once './config.php';

?>
  </header>
    <div id="month-div"></div>
    <div id="day-div"></div>

<?php } ?>

  </body>
</html>
