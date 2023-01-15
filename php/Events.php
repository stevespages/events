<?php

class Events {
  public function createEvent($db, $_POST) {
    $dateTimeStr = makeDateTimeStr($_POST['date'], $_POST['time']);
    $eventTimestamp = makeTimestamp($dateTimeStr);
    $dayOfMth = intval(substr($_POST['date'], -2));
    $mthOfYr = intval(substr($_POST['date'], -4, -2));
    $yr = intval(substr($_POST['date'], 0, 4));

    // Add uid when authentication is introduced

    $sql = "INSERT INTO events ('day_of_mth', 'mth_of_yr', 'yr', 'title', 'detail', 'date',";
    $sql .= " 'time', 'event_timestamp')";
    $sql .= " VALUES (:day_of_mth, :mth_of_yr, :yr, :title, :detail, :date, :time,";
    $sql .= " :event_timestamp)";
    var_dump($sql);
    $stmt = $db->prepare($sql);
    // Add uid when authentication is introduced
    // $stmt->bindParam(':uid', $_SESSION['uid']);
    $stmt->bindParam(':day_of_mth', $dayOfMth);
    $stmt->bindParam(':mth_of_yr', $mthOfYr);
    $stmt->bindParam(':yr', $yr);
    $stmt->bindParam(':title', $_POST['title']);
    $stmt->bindParam(':detail', $_POST['detail']);
    $stmt->bindParam(':date', $_POST['date']);
    $stmt->bindParam(':time', $_POST['time']);
    $stmt->bindParam(':event_timestamp', $eventTimestamp);

    $stmt->bindParam(':hosts_id', $_POST['hosts_id']);
    $stmt->bindParam(':venues_id', $_POST['venues_id']);

    $stmt->execute();
  }
}