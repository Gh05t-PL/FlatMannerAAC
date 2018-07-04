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
 
    mv FlatMannerAAC-master/{.,}* aac
    
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
    INSTALLATION LOGGING INTO aac/CRON/install.log
}
 
</pre>

Tested with TFS 0.3.6 && TFS 0.4 && TFS 1.2

