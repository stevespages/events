<?php

  require_once './php/error-reporting.php';

  require_once './config.php';

  session_start();

  if(empty($_SESSION['user'])){
    header('Location: ' . $loginRedirectURL);
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
