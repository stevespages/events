<?php

require_once '../../php/error-reporting.php';
require_once '../../php/Events.php';
require_once '../../php/db-functions.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
  $events = new Events();
  $events->createEvent($db, $_POST);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Events Class</h1>
  <p>
    The Events Class handles the  operations for creating, reading, updating and deleting (CRUD) events. It needs other software to display the events and to pass data to Events for creating new events or updating existing events.
  </p>
  <p>
    Some basic functionality is provided here which demonstrates the usage of Events. Displaying events and filtering them prior to display are considered here as well as attaching them to the output of the Calendar class for display in calendar format.
  </p>
  <h2>Create Event</h2>
  <form method = "post" class="simple-form">
    <fieldset>
      <legend>Create an Event</legend>
      <label for="title">Title</label>
      <input id="title" type="text" name="title">
      <label for="detail">Detail</label>
      <input id="detail" type="text" name="detail">
      <label for="date">Date</label>
      <input id="date" type="date" name="date">
      <label for="time">Time</label>
      <input id="time" type="time" name="time">
      <input type="submit">
    </fieldset>
  </form>
  <h2>Display Events List</h2>
  <h2>Display Events Calendar</h2>
</body>
</html>