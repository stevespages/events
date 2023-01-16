<?php

class Events {
  // 
  public function createEvent($db, $post) {
    var_dump($post);
    $data = [];
    // implement uid when authentication is added.
    $data['yr_st'] = intval(substr($post['date'], 0, 4));
    $data['mth_n_st'] = intval(substr($post['date'], -4, -2));
    $data['mth_str_st'] = date('M', mktime(0,0,0,$data['mth_n_st'],1,0));
    $data['day_n_st'] = intval(substr($post['date'], -2));
    $data['day_str_st'] = date('D', mktime(0,0,0,$data['mth_n_st'],$data['day_n_st'],$data['yr_st']));
    if(isset($post['time'])) {
      $data['hr_st'] = intval(substr($post['time'], 0, 2)) ? : null;
      $data['min_st'] = intval((substr($post['time'], -2))) ? : null;
    }
    // If time is not set make it '00:00' so ts_tz can be calculated
    // what is the :00+0000 ??? seconds and thousandths of secs??
    if(!isset($post['time']) || $post['time'] === ''){
      $post['time'] = '00:00';
    }
    $dateTimeStr = $post['date'] . "T" . $post['time'] . ":00+0000";
    // this wants to be ts_TZ. How can I ensure that?
    // this gives false if time is not set
    $data['ts_tz_st'] = strtotime($dateTimeStr);
    // After making sure ts_tz really is tz implement ts
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
    
    $sql = "INSERT INTO events ('yr_st', 'mth_n_st', 'mth_str_st',";
    $sql .= " 'day_n_st', 'day_str_st', 'hr_st', 'min_st', 'ts_tz_st',";
    $sql .= " 'title', 'detail', 'category') VALUES (:yr_st,";
    $sql .= " :mth_n_st, :mth_str_st, :day_n_st, :day_str_st, :hr_st,";
    $sql .= " :min_st, :ts_tz_st, :title, :detail, :category)";
    var_dump($sql);
    $stmt = $db->prepare($sql);
    // Add uid when authentication is introduced
    // $stmt->bindParam(':uid', $_SESSION['uid']);
    $stmt->bindParam(':yr_st', $data['yr_st']);
    $stmt->bindParam(':mth_n_st', $data['mth_n_st']);
    $stmt->bindParam(':mth_str_st', $data['mth_str_st']);
    $stmt->bindParam(':day_n_st', $data['day_n_st']);
    $stmt->bindParam(':day_str_st', $data['day_str_st']);
    $stmt->bindParam(':hr_st', $data['hr_st']);
    $stmt->bindParam(':min_st', $data['min_st']);
    $stmt->bindParam(':ts_tz_st', $data['ts_tz_st']);
    $stmt->bindParam(':title', $data['title']);
    $stmt->bindParam(':detail', $data['detail']);
    $stmt->bindParam(':category', $data['category']);

    $stmt->execute();
  
  }
}