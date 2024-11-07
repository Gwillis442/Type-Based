-- start Type-Based_Pop.sql
--Testing Insertion into Type-Based Database
set wrap off
set feedback off
set linesize 75

delete from user_account;
delete from user_config;
delete from math_stats;
delete from typing_stats;
delete from user_profile;

spool Type-Based_Pop.txt

--Inserting into user_profile
INSERT INTO user_profile VALUES ('12345678', 'John', 'Doe', 'fake@email.com');

--Inserting into user_account

INSERT INTO user_account VALUES ('12345678', 'username', 'password');

--Inserting into user_config

INSERT INTO user_config VALUES ('12345678', 'easy', 1, 1, 1);

--Inserting into math_stats

INSERT INTO math_stats VALUES ('12345678', 0.5, 10, 10, 10, 100, 100, 100);

--Inserting into typing_stats

INSERT INTO typing_stats VALUES ('12345678', 50, 10, 10, 10, 100, 100, 100);

--Selecting from user_profile

SELECT * FROM user_profile;

prompt
prompt Selecting from user_profile
prompt Should Print out:
prompt 12345678 John Doe

--Selecting from user_account

SELECT * FROM user_account;

prompt
prompt Selecting from user_account
prompt Should Print out:
prompt 12345678 johndoe password

--Selecting from user_config

SELECT * FROM user_config;

prompt
prompt Selecting from user_config
prompt Should Print out:
prompt 12345678 easy 1 1 1

--Selecting from math_stats

SELECT * FROM math_stats;

prompt
prompt Selecting from math_stats
prompt Should Print out:
prompt 12345678 0.5 10 10 10 100 100 100

--Selecting from typing_stats

SELECT * FROM typing_stats;

prompt
prompt Selecting from typing_stats
prompt Should Print out:
prompt 12345678 50 10 10 10 100 100 100


spool off