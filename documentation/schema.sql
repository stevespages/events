sqlite> .schema events
CREATE TABLE IF NOT EXISTS "events" (
  "id" INTEGER PRIMARY KEY,
  "uid" TEXT,

  "yr_st" INTEGER,
  "mth_st" INTEGER,
  "day_st" INTEGER,
  "hr_st" INTEGER,
  "min_st" INTEGER,
  "ts_ut_st" INTEGER,
  
  "yr_end" INTEGER,
  "mth_end" INTEGER,
  "day_end" INTEGER,
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
