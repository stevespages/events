<?php

  require_once '../php/error-reporting.php';

  require_once '../config.php';

  session_start();

  if(empty($_SESSION['user'])){
    header('Location: ' . $loginRedirectURL);
    exit();
  }

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once '../php/Events.php';
    require_once '../php/Calendar.php';
    require_once '../config.php';
    $events = new Events();
    $calendar = new Calendar();
    $events->createEvent($db, $_POST);
    header('Location: ../');
    exit();
  }

  /*
    * Get query string parameters to populate date input element
    */
  $yr = $_GET['yr'];
  $mth = $_GET['mth'];
  $day = $_GET['day'];

  function prependZero($mthOrDay){
    if(strlen($mthOrDay) === 1){
      return '0' . $mthOrDay;	
    } else {
    	return $mthOrDay;
    }
  }

  $mth = prependZero($mth);
  $day = prependZero($day);

  $dateValue = $yr . '-' . $mth . '-' . $day;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <title>Create Event</title>
  </head>
  <body>
  <h1>Create Event</h2>
    <form method = "post" class="simple-form">
      <fieldset>
        <legend>Create an Event</legend>
        <label for="title">Title</label>
        <input id="title" type="text" name="title">
        <label for="detail">Detail</label>
        <input id="detail" type="text" name="detail">
        <label for="date">Date</label>
        <input id="date" value="<?= $dateValue ?>" type="date" name="date">
        <label for="time">Start Time</label>
        <input id="time" type="time" name="start-time">
        <label for="time">End Time</label>
        <input id="time" type="time" name="end-time">
        <input type="submit">
        <a href="../">Cancel</a>
      </fieldset>
    </form>
  </body>
</html>
