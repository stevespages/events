<?php

  require_once './php/error-reporting.php';

  require_once '../config.php';

  session_start();

  if(empty($_SESSION['user'])){
    header('Location: ' . $loginRedirectURL);
    exit();
  }

  require_once '../php/Events.php';
  require_once '../php/Calendar.php';

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
