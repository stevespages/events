<?php
  session_start();

  /*
    * If the user is not logged in redirect them to
    * website's home page.
    *
    * You could change Location to any path.
    */
  if(empty($_SESSION['user'])){
    header('Location: ../'); // should be path to home page
    exit();
  }

  require_once '../php/error-reporting.php';

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    require_once '../php/Events.php';
    //require_once '../php/Calendar.php';
    //require_once '../php/functions.php';
    require_once '../config.php';
    $events = new Events();
    //$calendar = new Calendar();
    $events->deleteEvent($db, $_POST['delete-id']);
    header('Location: ../');
    exit();
  }

  /*
    * Get query string parameters for id of event to delete
    */
    $id = $_GET['id'];
?>

    <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/main.css" rel="stylesheet">
    <title>Delete Event</title>
  </head>
  <body>
  <h1>Delete Event</h2>
  <form method = "post" class="simple-form">
      <input type="hidden" name="delete-id" value="<?= $id ?>">
      <input type="submit" value="Delete">
      <a href="../">Cancel</a>
  </form>
  </body>