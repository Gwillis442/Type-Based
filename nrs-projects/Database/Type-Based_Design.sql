-- by: Chan Rain, Garrett Willis, Kevin Tieu
-- last modified: 2026-10-13

-- start Type-Based_Design.sql
drop table typing_stats;
drop table user_config;
drop table user_account;
drop table user_profile;

CREATE TABLE user_profile(
    user_id VARCHAR2(20) PRIMARY KEY,
    first_name VARCHAR2(50),
    last_name VARCHAR2(50),
    email VARCHAR2(50)
);

CREATE TABLE user_account(
    user_id VARCHAR2(20) PRIMARY KEY,
    username VARCHAR2(20),
    password VARCHAR2(255),
    FOREIGN KEY (user_id) REFERENCES user_profile(user_id)
);

CREATE TABLE user_config(
    user_id VARCHAR2(20) PRIMARY KEY,
    default_mode VARCHAR2(5),
    sound int,
    music int,
    play_history int,
    FOREIGN KEY (user_id) REFERENCES user_profile(user_id)
);

CREATE TABLE typing_stats(
    user_id VARCHAR2(20) PRIMARY KEY,
    wpm int,
    total_games_easy int,
    total_games_medium int,
    total_games_hard int,
    high_score_easy int,
    high_score_medium int,
    high_score_hard int,
    accuracy_easy int,
    accuracy_medium int,
    accuracy_hard int,
    avg_wpm_easy int,
    avg_wpm_medium int,
    avg_wpm_hard int,
    FOREIGN KEY (user_id) REFERENCES user_profile(user_id)
);
CREATE TABLE game_history(
    user_id VARCHAR2(20),
    played_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    mode VARCHAR2(10),
    score int,
    accuracy int
);
