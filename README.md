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
Edit .env file and change
<pre>
                        user      password             database name
                         V           V                     V
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"

to get database connection
</pre>
<br>
Edit \config\packages\GLOBALS.php 
<pre>
for own vocation names and server name
</pre>
<br>
<br>
<br>


IN YOUR DB execute this query
<pre>
ALTER TABLE player_skills ADD id INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY;
ALTER TABLE player_killers ADD id INT (11) NOT NULL AUTO_INCREMENT PRIMARY KEY;
</pre>
</div>
