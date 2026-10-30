-- by: Chan Rain, Garrett Willis, Kevin Tieu
-- SQLite tables for a local run. Same roles as the Oracle design.

CREATE TABLE IF NOT EXISTS user_profile(
    user_id TEXT PRIMARY KEY,
    first_name TEXT,
    last_name TEXT,
    email TEXT
);
CREATE TABLE IF NOT EXISTS user_account(
    user_id TEXT PRIMARY KEY,
    username TEXT,
    password TEXT,
    FOREIGN KEY (user_id) REFERENCES user_profile(user_id)
);
CREATE TABLE IF NOT EXISTS user_config(
    user_id TEXT PRIMARY KEY,
    default_mode TEXT,
    sound INTEGER,
    music INTEGER,
    play_history INTEGER,
    FOREIGN KEY (user_id) REFERENCES user_profile(user_id)
);
CREATE TABLE IF NOT EXISTS typing_stats(
    user_id TEXT PRIMARY KEY,
    wpm INTEGER,
    total_games_easy INTEGER,
    total_games_medium INTEGER,
    total_games_hard INTEGER,
    high_score_easy INTEGER,
    high_score_medium INTEGER,
    high_score_hard INTEGER,
    accuracy_easy INTEGER,
    accuracy_medium INTEGER,
    accuracy_hard INTEGER,
    avg_wpm_easy INTEGER,
    avg_wpm_medium INTEGER,
    avg_wpm_hard INTEGER,
    FOREIGN KEY (user_id) REFERENCES user_profile(user_id)
);
CREATE TABLE IF NOT EXISTS game_history(
    user_id TEXT,
    played_at TEXT DEFAULT CURRENT_TIMESTAMP,
    mode TEXT,
    score INTEGER,
    accuracy INTEGER
);
