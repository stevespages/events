<?php
  session_start();
  require_once './php/error-reporting.php';
  /*
  * If the user is not logged in redirect them to ./user
  *
  * You could change Location to any path.
  */
  if(empty($_SESSION['user'])){
    header('Location: ./user/');
    exit();
  }
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

    <div id="month-div"></div>
    <div id="day-div"></div>

  </body>
</html>
