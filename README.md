# Events Repository

This repository contains a PHP *Events* class for scheduling events. Events can be created and saved in a database. They can be retrieved and listed in order of when they are scheduled to start. Filters can be applied to restrict the list to certain categories or between certain time limits.

A PHP *Calendar* class is also included which can generate arrays of days spanning any month of any year.

The *Events* and *Calendar* classes can be used together to generate arrays of days which include event data in them.

A number of other PHP and JavaScript files are included which contain code for displaying and creating events in a month-view calendar. This can be used as a personal organizer. The *virtualcrossing* API has been integrated with the calendar so that the weather forecast for the next 15 days can be seen for today's date.

![screenshot of calendar](https://github.com/stevespages/events/blob/main/assets/photos/screenshot_calendar-small.jpg?raw=true "Screenshot of calendar")

## *Calendar* class

### Calendar::createMonth(obj $db, int $yr, int $mth, obj $events)

The description here is for the behavious of this function when an *Events* object and associated PDO Database object are not supplied as arguments. The behaviour when they are supplied is described in the section on the *Events* class.

If this argument is supplied with the value, false, for the first and last arguments ($db and $events) it will return an array of days for the month specified by the $yr and $mth arguments. Where a month does not start on a Monday, the first week will contain days from the previous month. Where a month does not end on a Sunday, the last week will contain days from the next month. An example of an array returned from this function is shown below.

Note that days from the previous month have a value of *"prev"* for the *"prev-curr-nxt"* key. Other days have *"curr"* or *"nxt"* indicating whether they are days from the month that was used in the $mth argument (*"curr"*) or the next month (*"nxt"*)

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
    array(4) {
      ["yr"]=>
      int(2023)
      ["mth"]=>
      int(1)
      ["day"]=>
      int(2)
      ["prev-curr-nxt"]=>
      string(4) "curr"
    }

// days have been ommited here for brevity

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

## *Events* class

Before describing the methods of this class, the fields or columns it requires in an SQL database are described. This database must have a table called *events* with the fields (columns) indicated in the tables below.

### Varibles / SQL Fields

When an event is created using `Events::createEvent($db, $post)`, a $post array will usually have been sent from an HTML form using the HTTP post method to the PHP script. The $post array must have certain keys which should be the same as the names of the required fields (columns) in the SQL table that stores the data. Certain optional fields may be supplied and again these must have the same name as indicated below for the SQL table fields.

### Required fields

| Fields        | Type   | Description                | Example    |
|---------------|--------|----------------------------|------------|
| yr_st         | INT    | year event starts          | 2023       |
| mth_st        | INT    | month event starts         | 12         |
| day_st        | INT    | day event starts           | 15         |
| title         | STR    | title of event             | Dentist    |
        
### Optional fields        
        
| Fields        | Type   | Description                | Example    |
|---------------|--------|----------------------------|------------|
| hr_st         | INT    | hour event starts          | 19         |
| min_st        | INT    | min event starts           | 30         |
| t_zone        | STR    | timezone for ts_st         | UTC−04:00  |
| yr_end        | INT    | year event ends            | 2024       |
| mth_end       | INT    | month event ends           | 1          |
| day_end       | INT    | day event ends             | 15         |
| hr_end        | INT    | hour event ends            | 19         |
| min_end       | INT    | minute event ends          | 45         |
| locations_id  | INT FK | links to location          | 23         |
| organizers_id | INT FK | links to organizer         | 19         |
| alarms_id     | INT FK | links to alarms            | 556        |
| detail        | STR    | detail about event         | filling    |
| category      | STR    | one of many categor's      | Medical    |

### Automatically generated fields

| Fields        | Type   | Description                | Example    |
|---------------|--------|----------------------------|------------|
| id            | INT 1K | Autoincremented primary key| 175        |
| uid           | INT FK | User ID from session var   | 37         |
| ts_ut_st      | INT    | UT timestamp for start     | 1672531200 |
| ts_ut_end     | INT    | UT timestamp for end       | 1672531200 |

### uid

This need not be used but is available for a user id in the form of an integer to be stored in. If session based authentication is used the a uid should be available to populate this field. The uid can then be used to restrict access to events to those which contain the current user's uid.

### If minutes not submitted

If a value is submitted for *hr_st* and null is submitted for *min_st*, then *min_st* should be set to 0. The same applies to *hr_end* and *min_end*.

### If hours and minutes not submitted

If values for *hr_st* and *min_st* are not submitted they, and *hr_end* and *min_end* (regardless of whether values were submitted for the *_end* fields) should all be persisted as null. In this case *ts_ut_st* and *ts_ut_end* will be calculated for 00hrs 00mins 00sec on the day that the event occurs on so their values will be the same.
      
### All Day Events

These should be implemented by creating a $datetime string in which the date components come from the submitted data. The time component for creating the *ts_ut_st* timestamp should be 00:00:00. The time component for creating *ts_ut_end* should be 23:59:59

### Time Zones

In general this is unlikely to be an issue where all the users submitting events are using the same time zone. However if different users are submitting dates and times from different timezones then they should submit their timezone. The submitted timezone will be stored in the *t_zone*.

If this is done, all dates and times will be converted to UT before calculating the Unix timestamp and storing it in the *ts_ut_st* and *ts_ut_end* fields. Note that *ts* stands for *timestamp*, *ut* stands for *universal time*, *st* stands for *start* (of the event) and *end* stands for *end* (of the event). A Unix timestamp is the number of seconds since 1 Jan 1970 00hr 00min 00sec UT.

The advantage of adjusting dates and times to UT before calculating and storing the information as a timestamp is that all the events can be retrieved in order of when they start in universal time which is the true order of their scheduled occurence. Retrieved timestamps can be adjusted if desired to any timezone if that is convenient for users living in different timezones.

### SQL Schema

The schema of the events table (using SQLite) is shown below:

```
sqlite> .schema events
CREATE TABLE IF NOT EXISTS "events" (
  "id" INTEGER PRIMARY KEY,
  "uid" TEXT,

  "yr_st" INTEGER,
  "mth_n_st" INTEGER,
  "day_n_st" INTEGER,
  "hr_st" INTEGER,
  "min_st" INTEGER,
  "ts_ut_st" INTEGER,
  
  "yr_end" INTEGER,
  "mth_n_end" INTEGER,
  "mth_str_end" TEXT,
  "day_n_end" INTEGER,
  "day_str_end" TEXT,
  "hr_end" INTEGER,
  "min_end" INTEGER,
  "ts_ut_end" INTEGER,
  "t_zone" TEXT,

  "locations_id" INTEGER,
  "organizers_id" INTEGER,
  "alarms_id" INTEGER,

  "title" TEXT,
  "detail" TEXT,
  "category" TEXT 

);
```

### Events::createEvent($db, $post)

This function persists HTML form post data to an SQL database. The required and optional keys and values are indicated in the tables above. $db needs to be a PDO object for a database such as SQLite, MySQL, MariaDB etc.

### Events::getList($db, $yr=null, $mth = null, $day = null)

This function returns an array of events ordered by ts_ut_st which is the UT timestamp of the start of an event. If $yr, $mth and $day are not supplied as arguments, all the events in the database will be returned. If only the year is provided as an argument all events for that year will be returned. If the year and month is provided, the events for that month are returned. If a year, month and day are provided then the events for that day will be returned.

### Events::populateMonth($month)

This method is used internally by the *Calendar* class when an *Events* object and PDO database object are passed to the *createMonth()* method: `Calendar::createMonth(obj $db, int $yr, int $mth, obj $events)`

The $month argument must only contain days from the same month. It can be only part of the month. It handles the *prev*, *curr* and *nxt* months separately. It gets the year, month and day-of-the-month of the first (also the earliest) day in $month and creates a timestamp from these values called *$tsUtFrom*. Similarly it creates $tsUtTo from the last (also the latest) day in $month.

The events table and joined tables are queried for events between *$tsUtFrom* and *$tsUtTo*. The first column in the SELECT statement is *'day_st'*. in the PDO::fetchAll() method the *PDO::FETCH_GROUP* constant is used as an argument. So the returned array is grouped in subarrays, indexed by the day of the month (the values in *'day_st'*).

Now the function iterates through each day in *$months* executing the following:

```
if($eventsArr[$months['days']['day']){
  $months['days']['day']['events'] = $eventsArr[$months['days']['day']];
}
```
The method returns the $month (month or part of a month of days) appended with an *"events* key with an array of events as value. If there are no events on a given day it will not be appended with an *"events"* key.

## *Calendar* and *Events* used together

We now look at using *Calendar::createMonth() where we pass an *Events* object and PDO database object to it as arguments.

### Calendar::createMonth(obj $db, int $yr, int $mth, obj $events). Again!

Previously we invoked this method with false for the first and last arguments. If our *Calendar* object was assigned to a variable called *$calendar* and our *Events* object was assigned to *$events* and our PDO database assigned to *$db* we can now invoke the function thus:

```
$calendar->createMonth($db, $yr, $mth, $events)
```

This will return an array similar to the array we saw earlier from this function but now the array elements in the *"days"* subarray will have another key value pair if there is one or more events scheduled on the day that array element represents. The key will be *"events"* and the value will be an array of one or more events. An example is shown below:

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
    array(5) {
      ["yr"]=>
      int(2022)
      ["mth"]=>
      int(12)
      ["day"]=>
      int(31)
      ["prev-curr-nxt"]=>
      string(4) "prev"
      ["events"]=>
      array(1) {
        [0]=>
        array(4) {
          ["hr_st"]=>
          int(8)
          ["min_st"]=>
          int(30)
          ["title"]=>
          string(25) "Make New Years Resolution"
          ["detail"]=>
          string(23) "give it lots of thought"
        }
      }
    }
    [6]=>
    array(5) {
      ["yr"]=>
      int(2023)
      ["mth"]=>
      int(1)
      ["day"]=>
      int(1)
      ["prev-curr-nxt"]=>
      string(4) "curr"
      ["events"]=>
      array(2) {
        [0]=>
        array(4) {
          ["hr_st"]=>
          int(12)
          ["min_st"]=>
          NULL
          ["title"]=>
          string(20) "New Year's Day Party"
          ["detail"]=>
          string(12) "fancy dress!"
        }
        [1]=>
        array(4) {
          ["hr_st"]=>
          int(19)
          ["min_st"]=>
          int(30)
          ["title"]=>
          string(10) "Fireworks!"
          ["detail"]=>
          string(22) "At the football ground"
        }
      }
    }
    [7]=>
    array(4) {
      ["yr"]=>
      int(2023)
      ["mth"]=>
      int(1)
      ["day"]=>
      int(2)
      ["prev-curr-nxt"]=>
      string(4) "curr"
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

// days ommited for brevity

    [35]=>
    array(4) {
      ["yr"]=>
      int(2023)
      ["mth"]=>
      int(1)
      ["day"]=>
      int(30)
      ["prev-curr-nxt"]=>
      string(4) "curr"
    }
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

## Code Summary

```
/ u?N login or register
  u?Y module ./main.js
      import showMonth, showDay
      fetchMonth(yr, mth NOW)
        fetch PHP Calendar::createMonth(db, yr, mth, Events)
          Calendar::createPrevMth > Events::populateMth
          ditto CurrMth
          ditto Nxt Mth
          array_merge(prev, curr, nxt)
          return month
          showMonth
      fetchDay(yr, mth, day, NOW)
        fetch PHP Events::getList(db, yr, mth, day)
        return events
        showDay

  Month Actions
    right / left arrow
      FetchMonth(yr, decremented / incremented mth)
    tbody > day
      FetchDay(yr, mth, day FOR CLICKED DAY)

  Day Actions
    + by date
      Events::createEvent(mth, yr, day FOR DAY) > header /
    - by event
      Events::deleteEvent > header /
```
