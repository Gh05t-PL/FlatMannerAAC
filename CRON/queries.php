<?php


$queries = [
    '1.2' => [
        "ALTER TABLE accounts ADD points INT (10) NOT NULL DEFAULT 0;"
    ],
    '0.4' => [
        "ALTER TABLE player_skills ADD id INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY;",
        "ALTER TABLE player_killers ADD id INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY;",
        "ALTER TABLE accounts ADD points INT (10) NOT NULL DEFAULT 0;"
    ],
    'all' => [
        "CREATE TABLE IF NOT EXISTS today_exp (
            id int AUTO_INCREMENT,
            exp bigint(20) NOT NULL,
            player_id int,
            PRIMARY KEY (id),
            FOREIGN KEY (player_id) REFERENCES players(id)
        );",

        "CREATE TABLE IF NOT EXISTS fmAAC_news (
            id int AUTO_INCREMENT,
            title varchar(50) NOT NULL,
            author varchar(50) NOT NULL,
            datetime DATETIME NOT NULL,
            text text CHARACTER SET 'utf8' NOT NULL,
            PRIMARY KEY (id)
        );",

        "CREATE TABLE IF NOT EXISTS fmAAC_logs_actions (
            id int AUTO_INCREMENT,
            name VARCHAR(60) NOT NULL,
            PRIMARY KEY (id)
        );",

        "CREATE TABLE IF NOT EXISTS fmAAC_logs (
            id int AUTO_INCREMENT,
            action_id int NOT NULL,
            datetime DATETIME NOT NULL,
            ip VARCHAR(15) NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (action_id) REFERENCES fmAAC_logs_actions(id)
        );",

        "CREATE TABLE IF NOT EXISTS fmAAC_shop_logs (
            id int AUTO_INCREMENT,
            points int NOT NULL,
            datetime DATETIME NOT NULL,
            account_id int NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (account_id) REFERENCES accounts(id)
        );",

        "CREATE TABLE IF NOT EXISTS fmAAC_statistics_online ( 
            id int AUTO_INCREMENT, 
            online_players int NOT NULL, 
            date DATETIME, PRIMARY KEY (id) 
        );",

        "CREATE TABLE IF NOT EXISTS fmAAC_calendar (datefield DATE);",

        "CREATE PROCEDURE fill_calendar(start_date DATE, end_date DATE)
BEGIN
DECLARE crt_date DATE;
SET crt_date=start_date;
WHILE crt_date < end_date DO
    INSERT INTO fmAAC_calendar VALUES(crt_date);
    SET crt_date = ADDDATE(crt_date, INTERVAL 1 DAY);
END WHILE;
END",

        "CALL fill_calendar('2018-01-01', '2025-12-31');",

        "INSERT INTO fmAAC_logs_actions VALUES (1,'Account Created');",
        "INSERT INTO fmAAC_logs_actions VALUES (2,'Account Deleted');",
        "INSERT INTO fmAAC_logs_actions VALUES (3,'Character Created');",
        "INSERT INTO fmAAC_logs_actions VALUES (4,'Character Deleted');",
        "INSERT INTO fmAAC_logs_actions VALUES (5,'Logged In');",
        "INSERT INTO fmAAC_logs_actions VALUES (6,'Account Changes');",
    ]
    ];

/*
TFS04
ALTER TABLE player_skills ADD id INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE player_killers ADD id INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY;

TFS12 & TFS04
ALTER TABLE accounts ADD points INT (10) NOT NULL DEFAULT 0;

CREATE TABLE IF NOT EXISTS today_exp (
    id int AUTO_INCREMENT,
    exp bigint(20) NOT NULL,
    player_id int,
    PRIMARY KEY (id),
    FOREIGN KEY (player_id) REFERENCES players(id)
);

CREATE TABLE IF NOT EXISTS fmAAC_news (
    id int AUTO_INCREMENT,
    title varchar(50) NOT NULL,
    author varchar(50) NOT NULL,
    datetime DATETIME NOT NULL,
    text text CHARACTER SET 'utf8' NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS fmAAC_logs_actions (
    id int AUTO_INCREMENT,
    name VARCHAR(60) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO fmAAC_logs_actions VALUES (1,"Account Created");
INSERT INTO fmAAC_logs_actions VALUES (2,"Account Deleted");
INSERT INTO fmAAC_logs_actions VALUES (3,"Character Created");
INSERT INTO fmAAC_logs_actions VALUES (4,"Character Deleted");
INSERT INTO fmAAC_logs_actions VALUES (5,"Logged In");
INSERT INTO fmAAC_logs_actions VALUES (6,"Account Changes");

CREATE TABLE IF NOT EXISTS fmAAC_logs (
    id int AUTO_INCREMENT,
    action_id int NOT NULL,
    datetime DATETIME NOT NULL,
    ip VARCHAR(15) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (action_id) REFERENCES fmAAC_logs_actions(id)
);




CREATE TABLE IF NOT EXISTS fmAAC_shop_logs (
    id int AUTO_INCREMENT,
    points int NOT NULL,
    datetime DATETIME NOT NULL,
    account_id int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (account_id) REFERENCES accounts(id)
);


CREATE TABLE IF NOT EXISTS fmAAC_statistics_online ( 
    id int AUTO_INCREMENT, 
    online_players int NOT NULL, 
    date DATETIME, PRIMARY KEY (id) 
);

CREATE TABLE IF NOT EXISTS fmAAC_calendar (datefield DATE);

DELIMITER |
CREATE PROCEDURE fill_calendar(start_date DATE, end_date DATE)
BEGIN
DECLARE crt_date DATE;
SET crt_date=start_date;
WHILE crt_date < end_date DO
    INSERT INTO fmAAC_calendar VALUES(crt_date);
    SET crt_date = ADDDATE(crt_date, INTERVAL 1 DAY);
END WHILE;
END |
DELIMITER ;


CALL fill_calendar('2018-01-01', '2025-12-31');
*/