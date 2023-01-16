# Events Class

This PHP class handles the operations for creating, reading, updating and deleting (CRUD) events. It needs other software to display the events and to pass data to Events for creating new events or updating existing events.

Some basic functionality is provided here which demonstrates the usage of Events. Displaying events and filtering them prior to display are considered here as well as attaching them to the output of the Calendar class for display in calendar format.

## Methods

### Events::createEvent($db, $post)

This function persists HTML form post data to an SQL database. $db needs to be a PDO object for a database such as SQLite, MySQL, MariaDB etc.

| Fields | Required? | Type | Description        | Example |
|--------|-----------|------|--------------------|---------|
| yr_st  | Yes       | INT  | year event starts  | 2023    |
| mth_st | Yes       | INT  | month event starts | 12      |

### Events::getList($yr, $mth = null, $day = null)

This function lists the events. If only the year is provided as an argument all events for that year will be shown. If the year and month is provided, the events for that month are shown. If a year, month and day are provided then the events for that day will be shown.
~                                                                   