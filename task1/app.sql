DROP TABLE bugs;
CREATE TABLE IF NOT EXISTS bugs (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title TEXT NOT NULL ,
  comment TEXT NOT NULL,
  urgency TEXT NOT NULL,
  status TEXT NOT NULL,
  updated_by INTEGER,
  engineer_comment TEXT,
  created_at TEXT NOT NULL DEFAULT current_timestamp,
  modified_at TEXT NOT NULL DEFAULT current_timestamp
);