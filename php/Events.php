<?php

class Events {
  
  public function createEvent($db, $post) {
    var_dump($post);
    $data = [];
    $data['yr_st'] = intval(substr($post['date'], 0, 4));
    $data['mth_st'] = intval(substr($post['date'], 5, 2));
    $data['day_st'] = intval(substr($post['date'], -2));
    // If time not set make it 0 (integer) so ts_ut can be calculated
    /*
    if(isset($post['time'])) {
      $data['hr_st'] = intval(substr($post['time'], 0, 2)) ? : 0;
      $data['min_st'] = intval((substr($post['time'], -2))) ? : 0;
    } else {
      $data['hr_st'] = 0;
      $data['min_st'] = 0;
    }
    */
    if(isset($post['start-time'])) {
      $data['hr_st'] = substr($post['start-time'], 0, 2) ? : '00';
      $data['min_st'] = substr($post['start-time'], -2) ? : '00';
    } else {
      $data['hr_st'] = '00';
      $data['min_st'] = '00';
    }
    if(isset($post['end-time'])) {
      $data['hr_end'] = substr($post['end-time'], 0, 2) ? : '00';
      $data['min_end'] = substr($post['end-time'], -2) ? : '00';
    } else {
      $data['hr_end'] = '00';
      $data['min_end'] = '00';
    }
    $dateTimeStr = $post['date'] . "T" . $data['hr_st'] . ':' .$data['min_st'] . ":00+0000";
    // $dateTimeStr = $post['date'] . "T" . $post['time'] . ":00+0000";
    // this wants to be ts_ut. How can I ensure that?
    // this gives false if time is not set
    $data['ts_ut_st'] = strtotime($dateTimeStr);
    // After making sure ts_ut really is ut implement ts
    // End times need to be implemented
    // Make locations, organizers and alarms tables. Then implement here
    $data['title'] = $post['title'];
    $data['detail'] = $post['detail'] ? : null;
    if(isset($post['category'])){
      $data['category'] = $post['category'] ? : null;
    }
    echo '<pre><code>';
    var_dump($data);
    echo '</code></pre>';

    // It is possible for a user's session to end before they ...
    // ... submit the form. In that case $_SESSION['uid'] will ...
    // ... be unavailable and the row will not have a value for ...
    // ... the uid. A solution needs to be implemented eg. check ...
    // ... for uid and if not available do not store row and do ...
    // ... inform user.
    // Is this valid???
    $uid = $_SESSION['uid'];
    if(empty($uid)){
      // URL would be better put into a config.php file
      // Attach a query string with message to user?
      header('Location: http://stevespages.org.uk/events');
      exit();
    }
      $sql = "INSERT INTO events ('uid', 'yr_st', 'mth_st',";
      $sql .= " 'day_st', 'hr_st', 'min_st', 'ts_ut_st',";
      $sql .= " 'title', 'detail', 'category') VALUES (:uid, :yr_st,";
      $sql .= " :mth_st, :day_st, :hr_st,";
      $sql .= " :min_st, :ts_ut_st, :title, :detail, :category)";
      var_dump($sql);
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':uid', $_SESSION['uid']);
      $stmt->bindParam(':yr_st', $data['yr_st']);
      $stmt->bindParam(':mth_st', $data['mth_st']);
      $stmt->bindParam(':day_st', $data['day_st']);
      $stmt->bindParam(':hr_st', $data['hr_st']);
      $stmt->bindParam(':min_st', $data['min_st']);
      $stmt->bindParam(':ts_ut_st', $data['ts_ut_st']);
      $stmt->bindParam(':title', $data['title']);
      $stmt->bindParam(':detail', $data['detail']);
      $stmt->bindParam(':category', $data['category']);
      $stmt->execute();
  
  }

  public function deleteEvent($db, $id){
    $sql = 'DELETE FROM events WHERE id = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
  }

  public function getList($db, $yr, $mth = null, $day = null) {

    // Valid arguments:
    // $yr
    // $yr and $month
    // $yr and $month and $day
    // Invalid arguments:
    // $yr and $day. This probably causes an error.

    // If $day isset get events for that day
    // If $day is null get events for a full month
    // If $mth and $day is null get events for a full year
    // If $day is set but $mth is null it is an error. How to prevent?

    // Convert strings to integers.
    // Assign default values to arguments that were not supplied.
    $yr = intval($yr);
    $mth = $mth ? intval($mth) : null;
    $day = $day ? intval($day) : null;

    $data = [];
    $data['yr'] = $yr;
    $data['mth'] = $mth;
    $data['day'] = $day;

    if(is_null($mth) && is_null($day)){
      $datetime = $yr . '-01-01';
      $tsUtFrom = strtotime($datetime);
      $tsUtTo = strtotime('+ 1 year', $tsUtFrom);
    }

    if(!is_null($mth) && is_null($day)){
      $datetime = $yr . '-' . $mth . '-01';
      $tsUtFrom = strtotime($datetime);
      $tsUtTo = strtotime('+ 1 month', $tsUtFrom);
    }

    if(!is_null($mth) && !is_null($day)){
      $datetime = $yr . '-' . $mth . '-' . $day;
      $tsUtFrom = strtotime($datetime);
      $tsUtTo = strtotime('+ 1 day', $tsUtFrom);
    }

    $data['datetime'] = $datetime;
    $data['ts-ut-from'] = $tsUtFrom;
    $data['ts-ut-to'] = $tsUtTo;

    $sql = "SELECT id, hr_st, min_st, title, detail FROM events WHERE ts_ut_st > :ts_ut_from";
    $sql .= " AND ts_ut_st < :ts_ut_to ORDER BY ts_ut_st";
    
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':ts_ut_from', $data['ts-ut-from']);
    $stmt->bindParam(':ts_ut_to', $data['ts-ut-to']);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
  }

  public function populateMonth($db, $month){
    // generate $tsUtFrom
    $yr = $month[0]['yr'];
    $mth = $month[0]['mth'];
    $day = $month[0]['day'];
    $datetime = $yr . '-' . $mth . '-' . $day;
    $tsUtfrom = strtotime($datetime);

    // generate $tsUtTo
    $yr = $month[count($month) -1 ]['yr'];
    $mth = $month[count($month) -1 ]['mth'];
    $day = $month[count($month) -1 ]['day'];
    $datetime = $yr . '-' . $mth . '-' . $day . 'T23:59:59';
    $tsUtTo = strtotime($datetime);

    $sql = "SELECT day_st, hr_st, min_st, title, detail FROM events WHERE ts_ut_st > :ts_ut_from";
    $sql .= " AND ts_ut_st < :ts_ut_to";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':ts_ut_from', $tsUtfrom);
    $stmt->bindParam(':ts_ut_to', $tsUtTo);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

    for($i = 0; $i < count($month); $i++){
      if(isset($result[$month[$i]['day']])){
        $month[$i]['events'] = $result[$month[$i]['day']];
      }
    }
    return $month;
  }

}