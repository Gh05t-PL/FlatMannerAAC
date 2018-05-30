<div align=center>
<img src="http://ghost-web.pl/images/flatmannerLogo.svg" alt="" width="90" height="90">
<h1>FlatMannerAAC</h1>
Automated Account Maker created for Open Tibia Servers with Symfony 4 MVC framework
<br>
<br>
<br>
<br>
<br>
<h1>Installation</h1>
</div>
<pre>
 

0 EXECUTE THIS QUERIES 
{
    ALTER TABLE player_skills ADD id INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY;
    ALTER TABLE player_killers ADD id INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY;
    ALTER TABLE accounts ADD points INT (10) NOT NULL DEFAULT 0;

    CREATE TABLE today_exp (
        id int AUTO_INCREMENT,
        exp int NOT NULL,
        player_id int,
        PRIMARY KEY (id),
        FOREIGN KEY (player_id) REFERENCES players(id)
    );

    CREATE TABLE fmAAC_news (
        id int AUTO_INCREMENT,
        title varchar(50) NOT NULL,
        player_id int NOT NULL,
        datetime DATETIME NOT NULL,
        text text CHARACTER SET 'utf8' NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (player_id) REFERENCES players(id)
    );

    CREATE TABLE fmAAC_logs_actions (
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

    CREATE TABLE fmAAC_logs (
        id int AUTO_INCREMENT,
        action_id int NOT NULL,
        datetime DATETIME NOT NULL,
        ip VARCHAR(15) NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (action_id) REFERENCES fmAAC_logs_actions(id)
    );




    CREATE TABLE fmAAC_shop_logs (
        id int AUTO_INCREMENT,
        points int NOT NULL,
        datetime DATETIME NOT NULL,
        account_id int NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (account_id) REFERENCES accounts(id)
    );


    CREATE TABLE fmAAC_statistics_online ( 
        id int AUTO_INCREMENT, 
        online_players int NOT NULL, 
        date DATETIME, PRIMARY KEY (id) 
    );

    CREATE TABLE fmAAC_calendar (datefield DATE);

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
}



1 IN CONSOLE
{
    sudo apt-get install p7zip-full
 
 
    sudo apt-get update
    &&
    sudo apt-get upgrade
    &&
    sudo add-apt-repository ppa:ondrej/php
    &&
    sudo apt-get update
    &&
    sudo apt-get install -y apache2
    &&
    sudo apt-get install -y php7.2 libapache2-mod-php7.2 php7.2-cli php7.2-common php7.2-mbstring php7.2-gd php7.2-intl php7.2-xml php7.2-mysql php7.2-zip
    &&
    sudo apt-get install mysql-server
    &&
    sudo apt-get install composer
}
 
 
 
2 EDIT FILE /etc/apache2/sites-enabled/000-default.conf
{
CHANGE
    DocumentRoot /var/www/html
TO
    DocumentRoot /var/www/html/aac/public
    <Directory /var/www/html/aac/public>
        AllowOverride All
        Order Allow,Deny
        Allow from All
    </Directory>
}
 
 
 
3 IN CONSOLE
{
    cd /var/www/html
 
 
    wget https://github.com/Gh05t-PL/FlatMannerAAC/archive/master.zip
 
 
    mkdir aac
 
    7z x master.zip
 
    mv FlatMannerAAC-master/* aac
}
 
 

4 IN CONSOLE
{
    composer install
 
    chmod 777 -R /var/www/html/aac
    sudo a2enmod rewrite
 
IF YOU HAVE OTHER PHP INSTALLATION YOU MUST DISABLE IT WITH
    a2dismod php{phpVersion}
FOR EXAMPLE
    a2dismod php7.0
AND THEN ENABLE PHP7.2
    a2enmod php7.2
}



5 IN CONSOLE
{
    bash install.sh

    PROCEED WITH CAUTION!
    IN CASE OF ERROR GO TO

    https://otland.net/threads/fmaac-flatmanneraac-mvc-symfony4.258502/


    CRON TASKS LOGGING INTO aac/CRON/crons.log
}
 
</pre>

Tested with TFS 0.3.6 && TFS 0.4

