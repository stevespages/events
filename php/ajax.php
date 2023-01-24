<?php

  require_once '../php/error-reporting.php';
  require_once '../php/Events.php';
  require_once '../php/Calendar.php';
  require_once '../php/cal-demo.php';
  require_once '../config.php';

  $events = new Events();
  $calendar = new Calendar();

  $yr = intval($_GET['yr']);
  $mth = intval($_GET['mth']);

  if(isset($_GET['day'])){
    $day = intval($_GET['day']);
    $dayList = $events->getList($db, $yr, $mth, $day);
    $jsonString = json_encode(($dayList));
  } else {
    $month = $calendar->createMonth($db, $yr, $mth, $events);
    $jsonString = json_encode($month);
  }

  echo $jsonString;
  exit();
