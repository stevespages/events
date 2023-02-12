CREATE TABLE IF NOT EXISTS "meetups" (
  "id" INTEGER PRIMARY KEY,
  "uid" TEXT,

  "yr_st" TEXT,
  "mth_st" TEXT,
  "day_st" TEXT,
  "hr_st" TEXT,
  "min_st" TEXT,
  "ts_ut_st" INTEGER,
  
  "yr_end" TEXT,
  "mth_end" TEXT,
  "day_end" TEXT,
  "hr_end" TEXT,
  "min_end" TEXT,
  "ts_ut_end" INTEGER,
  "t_zone" TEXT,

  "region" TEXT,
  "locations_id" INTEGER,
  "organizers_id" INTEGER,
  "alarms_id" INTEGER,

  "title" TEXT,
  "detail" TEXT,
  "category" TEXT 

);
