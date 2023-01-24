<?php
function calDemo($month) {
    $days = $month['days'];
    echo "<table class='cal-ev'>";
    echo "<caption>";
    echo "<a href='#'> < </a>";
    echo "{$month['mth-str-abrev']} {$month['yr']}";
    echo "<a href='#'> > </a>";
    echo "</caption>";
    echo '<thead>';
    echo '<tr><td>M</td><td>T</td><td>W</td><td>T</td><td>F</td>
      <td>S</td><td>S</td></tr>';
    echo '</head>';
    echo '<tbody>';
    // Iterate through the $days array 1 week at a time  
    $i = 0;
    $iStop = 7;
    while(true){
      echo '<tr>';
      for($i; $i < $iStop; $i++){
        if(isset($days[$i]['events'])){
          $eventsDay = 'events';
        } else {
          $eventsDay = 'no-events';
        }
        echo "<td class='{$days[$i]['prev-curr-nxt']} {$eventsDay}'><a href='#'>";
        echo "{$days[$i]['day']}</a></td>";
      }
      echo '</tr>';
      if(isset($days[$i + 1])){
        $iStop = $iStop + 7;
      } else {
        break;
      }
    }
    echo '</tbody>';
    echo '</table>';
}
