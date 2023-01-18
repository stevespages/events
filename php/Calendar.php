<?php
// In some circumstances it may be necessary to set the ...
// ... date_default_timezone_set(string $timezoneId): bool
// I have not found it necessary yet.

class Calendar
{

  public function createCurrMth($yr, $mth)
  {

    $days = [];

    // $nDaysInMth is the number of days in the month
    $nDaysInMth = intval(date('t', mktime(0, 0, 0, $mth, 1, $yr)));

    for ($i = 1; $i < $nDaysInMth + 1; $i++) {
      $day = [];
      $day['yr'] = $yr;
      $day['mth'] = $mth;
      $day['day'] = $i;
      $day['prev-curr-nxt'] = 'curr';
      array_push($days, $day);
    }
    return $days;
  }

  public function createPrevMth($yr, $mth)
  {
    $days = [];

    $prevYr = ($mth === 1) ? $yr - 1 : $yr;
    $prevMth = ($mth === 1) ? 12 : $mth - 1;

    // $fdomAsdowAsN stands for...
    // ... first day of [curr] month As day of [the] week As Number.
    // 1 (for Monday) through 7 (for Sunday)
    $fdomAsdowAsN = date('N', mktime(0, 0, 0, $mth, 1, $yr));

    // number of days to show in prev month
    // if first day of month is Wed then...
    // ... $nodtsipm = 2 (ie Mon and Tues)
    $nodtsipm = $fdomAsdowAsN - 1;

    $nDaysInPrevMth = intval(date('t', mktime(0, 0, 0, $prevMth, 1, $prevYr)));

    for ($i = $nDaysInPrevMth - $nodtsipm + 1; $i < $nDaysInPrevMth + 1; $i++) {
      $day = [];
      $day['yr'] = $prevYr;
      $day['mth'] = $prevMth;
      $day['day'] = $i;
      $day['prev-curr-nxt'] = 'prev';
      array_push($days, $day);
    }
    return $days;
  }

  public function createNxtMth($yr, $mth)
  {
    $days = [];

    $nxtYr = ($mth === 12) ? $yr + 1 : $yr;
    $nxtMth = ($mth === 12) ? 1 : $mth + 1;

    // $nDaysInMth is the number of days in the curr month
    $nDaysInMth = intval(date('t', mktime(0, 0, 0, $mth, 1, $yr)));

    // $ldomAsdowAsN stands for...
    // ... last day of [curr] month As day of [the] week As Number.
    // 1 (for Monday) through 7 (for Sunday)
    $ldomAsdowAsN = date('N', mktime(0, 0, 0, $mth, $nDaysInMth, $yr));

    // number of days to show in nxt month
    // if last day of month is Thurs then...
    // ... $nodtsipm = 3 (ie Fri, Sat, Sun)
    $nodtsinm = 7 - $ldomAsdowAsN;

    for ($i = 1; $i < $nodtsinm + 1; $i++) {
      $day = [];
      $day['yr'] = $nxtYr;
      $day['mth'] = $nxtMth;
      $day['day'] = $i;
      $day['prev-curr-nxt'] = 'nxt';
      array_push($days, $day);
    }
    return $days;
  }

  public function createMonth($db, $yr, $mth, $events)
  {
    $month = [];

    $prevMth = $this->createPrevMth($yr, $mth);
    $currMth = $this->createCurrMth($yr, $mth);
    $nxtMth = $this->createNxtMth($yr, $mth);

    if($db && $events){
      $prevMth = $events->populateMonth($db, $prevMth);
      $currMth = $events->populateMonth($db, $currMth);
      $nxtMth = $events->populateMonth($db, $nxtMth);
    }
    //return $prevMth;
    $days = array_merge($prevMth, $currMth, $nxtMth);

    $mthStr = date('F', mktime(0, 0, 0, $mth, 1, $yr));
    $mthStrAbrev = date('M', mktime(0, 0, 0, $mth, 1, $yr));

    $month['yr'] = $yr;
    $month['mth'] = $mth;
    $month['mth-str'] = $mthStr;
    $month['mth-str-abrev'] = $mthStrAbrev;
    $month['days'] = $days;

    return $month;
  }
}
