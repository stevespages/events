# Events Class

This PHP class handles the operations for creating, reading, updating and deleting (CRUD) events. It needs other software to display the events and to pass data to Events for creating new events or updating existing events.

Some basic functionality is provided here which demonstrates the usage of Events. Displaying events and filtering them prior to display are considered here as well as attaching them to the output of the Calendar class for display in calendar format.

## Methods

### Events::createEvent($db, $post)

This function persists HTML form post data to an SQL database. $db needs to be a PDO object for a database such as SQLite, MySQL, MariaDB etc.

### Required fields

| Fields        | SQLite | PHP   | Description          | Example  |
|---------------|--------|-------|----------------------|----------|
| yr_st         | INT    | INT   | year event starts    | 2023     |
| mth_n_st      | INT    | INT   | month event starts   | 12       |
| day_n_st      | INT    | INT   | day event starts     | 15       |
| hr_st         | INT    | INT   | hour event starts    | 19       |
| min_st        | INT    | INT   | min event starts     | 30       |
| title         | STR    | STR   | title of event       | Dentist  |

### Optional fields

| Fields        | SQLite | PHP   | Description          | Example  |
|---------------|--------|-------|----------------------|----------|
| uid           | INT    | INT   | user id (auth'n)     | 1879     |
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

### Automatically generated fields

| Fields        | SQLite | PHP   | Description          | Example  |
|---------------|--------|-------|----------------------|----------|
| mth_str_st    | STR    | STR   | month event starts   | dec      |
| day_str_st    | STR    | STR   | dav event starts     | fri      |
| ts_tz_st      | INT    | INT   | timestamp in sec UT  | 10 digit |
| ts_st         | INT    | INT   | timestamp TZ various | 10 digit |

### Events::getList($db, $yr, $mth = null, $day = null)

This function lists the events. If only the year is provided as an argument all events for that year will be shown. If the year and month is provided, the events for that month are shown. If a year, month and day are provided then the events for that day will be shown.
