CREATE TABLE IF NOT EXISTS "events" (
  "id" INTEGER PRIMARY KEY,
  "uid" TEXT,

  "yr_st" INTEGER,
  "mth_n_st" INTEGER,
  "mth_str_st" TEXT,
  "day_n_st" INTEGER,
  "day_str_st" TEXT,
  "hr_st" INTEGER,
  "min_st" INTEGER,
  "ts_tz_st" INTEGER,
  "ts_st" INTEGER,

  "yr_end" INTEGER,
  "mth_n_end" INTEGER,
  "mth_str_end" TEXT,
  "day_n_end" INTEGER,
  "day_str_end" TEXT,
  "hr_end" INTEGER,
  "min_end" INTEGER,
  "ts_tz_end" INTEGER,
  "ts_end" INTEGER,

  "locations_id" INTEGER,
  "organizers_id" INTEGER,
  "alarms_id" INTEGER,

  "title" TEXT,
  "detail" TEXT,
  "category" TEXT, 

);
