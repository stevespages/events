# Events Class

This PHP class handles the operations for creating, reading, updating and deleting (CRUD) events. It needs other software to display the events and to pass data to Events for creating new events or updating existing events.

Some basic functionality is provided here which demonstrates the usage of Events. Displaying events and filtering them prior to display are considered here as well as attaching them to the output of the Calendar class for display in calendar format.

## Varibles / SQL Fields

When an event is created using `Events::createEvent($db, $post)`, a $post array will usually be sent from an HTML form using the HTTP post method to the PHP script. The $post array must have certain keys which are listed in the *Required fields* table below as these are the names of the required columns in the SQL table that stores the data. Certain optional fields may be supplied.

### Required fields

| Fields        | SQLite | PHP   | Description          | Example  |
|---------------|--------|-------|----------------------|----------|
| yr_st         | INT    | INT   | year event starts    | 2023     |
| mth_n_st      | INT    | INT   | month event starts   | 12       |
| day_n_st      | INT    | INT   | day event starts     | 15       |
| title         | STR    | STR   | title of event       | Dentist  |

### Optional fields

| Fields        | SQLite | PHP   | Description          | Example  |
|---------------|--------|-------|----------------------|----------|
| uid           | INT    | INT   | user id (auth'n)     | 1879     |
| hr_st         | INT    | INT   | hour event starts    | 19       |
| min_st        | INT    | INT   | min event starts     | 30       |
| ts_t_zone     | STR    | STR   | timezone for ts_st   | UTC−04:00|
| yr_end        | INT    | INT   | year event ends      | 2024     |
| mth_n_end     | INT    | INT   | month event ends     | 1        |
| mth_str_end   | STR    | STR   | month event ends     | jan      |
| day_n_end     | INT    | INT   | day event ends       | 31       |
| day_str_end   | STR    | STR   | day event ends       | wed      |
| locations_id  | INT FK | INT   | links to location    | 23       |
| organizers_id | INT FK | INT   | links to organizer   | 19       |
| alarms_id     | INT FK | INT   | links to alarms      | 556      |
| detail        | STR    | STR   | detail about event   | filling  |
| category      | STR    | STR   | one of many categor's| work     |

### All Day Events

These should be implemented by creating these field / value pairs:

| Field    | Value  |
|----------|--------|
| hr_st    | 0      |
| min_st   | 0      |
| hr_end   | 23     |
| min_end  | 59     |

### Events where time is not specified

If the time of the event is not specified, hr_st and min_st should be null.
In this case ts_t_zone will be calculated for 00hrs 00mins on the day that the event occurs on. If hr_st and min_st are both null, hr_end and min_end should be null.

### Hour and minutes
If hr_st has a value then min_st should have a value (ie. should not be null). If the user only supplies an hr_st, a value (eg 0) can be assigned to min_st. This applies to hr_end and min_end as well.

## Methods

### Events::createEvent($db, $post)

This function persists HTML form post data to an SQL database. The required and optional keys and values are indicated in the tables above. $db needs to be a PDO object for a database such as SQLite, MySQL, MariaDB etc.

### Events::getList($db, $yr=null, $mth = null, $day = null)

This function returns an array of events ordered by ts_tz_st which is the UT timestamp of the start of an event. If $yr, $mth and $day are not supplied as arguments, all the events in the database will be returned. If only the year is provided as an argument all events for that year will be returned. If the year and month is provided, the events for that month are returned. If a year, month and day are provided then the events for that day will be returned.

### Events::getMonth($db, $month)
**REPLACED BY populateMonth()**

This function requires a $month array, created by `Calendar::createMonth()`.
The function modifies the $month array by adding an array of events for any "days" subarray in the $month array. Note that the $month array contains the full weeks that the calendar spans. Where a month does not start on a Monday the first week will contain days from the previous month. Where a month does not end on a Sunday the last week will contain days from the next month. An example of an array returned from this function is shown below.

```

array(5) {
  ["yr"]=>
  int(2023)
  ["mth"]=>
  int(1)
  ["mth-str"]=>
  string(7) "January"
  ["mth-str-abrev"]=>
  string(3) "Jan"
  ["days"]=>
  array(42) {
    [0]=>
    array(4) {
      ["yr"]=>
      int(2022)
      ["mth"]=>
      int(12)
      ["day"]=>
      int(26)
      ["prev-curr-nxt"]=>
      string(4) "prev"
    }
    [1]=>
    array(4) {
      ["yr"]=>
      int(2022)
      ["mth"]=>
      int(12)
      ["day"]=>
      int(27)
      ["prev-curr-nxt"]=>
      string(4) "prev"
    }
    [2]=>
    array(4) {
      ["yr"]=>
      int(2022)
      ["mth"]=>
      int(12)
      ["day"]=>
      int(28)
      ["prev-curr-nxt"]=>
      string(4) "prev"
    }
    [3]=>
    array(4) {
      ["yr"]=>
      int(2022)
      ["mth"]=>
      int(12)
      ["day"]=>
      int(29)
      ["prev-curr-nxt"]=>
      string(4) "prev"
    }
    [4]=>
    array(4) {
      ["yr"]=>
      int(2022)
      ["mth"]=>
      int(12)
      ["day"]=>
      int(30)
      ["prev-curr-nxt"]=>
      string(4) "prev"
    }
    [5]=>
    array(4) {
      ["yr"]=>
      int(2022)
      ["mth"]=>
      int(12)
      ["day"]=>
      int(31)
      ["prev-curr-nxt"]=>
      string(4) "prev"
    }
    [6]=>
    array(4) {
      ["yr"]=>
      int(2023)
      ["mth"]=>
      int(1)
      ["day"]=>
      int(1)
      ["prev-curr-nxt"]=>
      string(4) "curr"
    }
    [7]=>
    array(5) {
      ["yr"]=>
      int(2023)
      ["mth"]=>
      int(1)
      ["day"]=>
      int(2)
      ["prev-curr-nxt"]=>
      string(4) "curr"
      ["events"]=>
      array(2) {
        [0]=>
        array(4) {
          ["hr_st"]=>
          int(10)
          ["min_st"]=>
          int(30)
          ["title"]=>
          string(7) "Dentist"
          ["detail"]=>
          string(22) "Filling and extraction"
        }
                [0]=>
        array(5) {
          ["hr_st"]=>
          int(16)
          ["min_st"]=>
          int(00)
          ["title"]=>
          string(7) "Finance Meeting"
          ["organizers-id"]=>
          int(9)
          ["category"]=>
          string(6) "online"
        }
      }
    }
    [8]=>
    array(4) {
      ["yr"]=>
      int(2023)
      ["mth"]=>
      int(1)
      ["day"]=>
      int(3)
      ["prev-curr-nxt"]=>
      string(4) "curr"
    }
    [9]=>
    array(4) {
      ["yr"]=>
      int(2023)
      ["mth"]=>
      int(1)
      ["day"]=>
      int(4)
      ["prev-curr-nxt"]=>
      string(4) "curr"
    }
 
// several days have been omitted here

    [36]=>
    array(4) {
      ["yr"]=>
      int(2023)
      ["mth"]=>
      int(1)
      ["day"]=>
      int(31)
      ["prev-curr-nxt"]=>
      string(4) "curr"
    }
    [37]=>
    array(4) {
      ["yr"]=>
      int(2023)
      ["mth"]=>
      int(2)
      ["day"]=>
      int(1)
      ["prev-curr-nxt"]=>
      string(3) "nxt"
    }
    [38]=>
    array(4) {
      ["yr"]=>
      int(2023)
      ["mth"]=>
      int(2)
      ["day"]=>
      int(2)
      ["prev-curr-nxt"]=>
      string(3) "nxt"
    }
    [39]=>
    array(4) {
      ["yr"]=>
      int(2023)
      ["mth"]=>
      int(2)
      ["day"]=>
      int(3)
      ["prev-curr-nxt"]=>
      string(3) "nxt"
    }
    [40]=>
    array(4) {
      ["yr"]=>
      int(2023)
      ["mth"]=>
      int(2)
      ["day"]=>
      int(4)
      ["prev-curr-nxt"]=>
      string(3) "nxt"
    }
    [41]=>
    array(4) {
      ["yr"]=>
      int(2023)
      ["mth"]=>
      int(2)
      ["day"]=>
      int(5)
      ["prev-curr-nxt"]=>
      string(3) "nxt"
    }
  }
}
```

### Events::populateMonth($month)

*$month* should be an array representing part or a whole month as in *prev*, *curr* and *nxt* months from the *Calendar* class. See (???) for the structure of the *$month* array.

This function gets the year, month and day of the month of the first (also the earliest) day in $month and creates a timestamp from these values called *$tsTzFrom*. Similarly it creates $tsTzTo from the last day in $month.

The events table and joined tables are queried for events between *$tsTzFrom* and *$tsTzTo*. The first column in the SELECT statement is *'day_n_st'*. in the PDO::fetchAll() method the *PDO::FETCH_GROUP* constant is used as an argument. So the returned array is grouped in subarrays, indexed by the day of the month (the values in *'day_n_st'*).

An example of an array returned by the SQL query from a month in which there were 2 events on the 6th of the month and one event on the 19th is shown below:

```
array(2) {
  [6]=>
  array(2) {
    [0]=>
    array(4) {
      ["hr_st"]=>
      int(10)
      ["min_st"]=>
      int(30)
      ["title"]=>
      string(7) "Dentist"
      ["detail"]=>
      string(22) "Extraction and filling"
    }
    [1]=>
    array(3) {
      ["hr_st"]=>
      int(16)
      ["min_st"]=>
      int(37)
      ["title"]=>
      string(15) "Train to London"
    }
  }
  [19]=>
  array(1) {
    [0]=>
    array(3) {
      ["hr_st"]=>
      int(11)
      ["min_st"]=>
      int(0)
      ["title"]=>
      string(11) "Golf Course"
    }
  }
}
```
Now the function iterates through each day in *$months* executing the following:

```
if($eventsArr[$months['days']['day']){
  $months['days']['day']['events'] = $eventsArr[$months['days']['day']];
}
```
As *$months* is passed by reference to this function the changes to it will have occured and there is no need to return anything from this function. It has now been populated with events.

## To Do

### Add
-ts_t_zone (eg UTC−04:00)

### Remove (derived from other fields)
-mth_str_st
-day_str_st
-ts_tz_st
-ts_st