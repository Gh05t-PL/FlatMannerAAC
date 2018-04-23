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
1. Download Composer <a href="https://getcomposer.org/download/">Click!</a><br>
2. Download fmAAC<br>
3. Unpack it to desired server folder<br>
4. Edit \.env.dist and change:<br>
<pre>
APP_ENV=prod
                        user      password             database name
                         V           V                     V
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

to get database connection</pre>
<br>
5. Edit \config\packages\GLOBALS.php with your own vocation data and server name(to edit player stats go to \src\Controller\AccountController.php and go to createCharacter function and find $startStats)
<br><br>
6. Open command line and navigate to aac root folder and type
<pre>
composer install
</pre>
7. Edit Apache server DocumentRoot to "public" folder of AAC
<br>
<br>
8. In your DataBase execute this query
<pre>
ALTER TABLE player_skills ADD id INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE player_killers ADD id INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY;
</pre>

Tested with TFS 0.3.6
</div>
