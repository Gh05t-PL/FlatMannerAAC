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



1. Install 7z for extracting files, apache web server, php7.2, mysql server and composer for futher installation process
```shell
#install 7z
$ sudo apt-get install p7zip-full

#reload package lists
$ sudo apt-get update

#fetch updates
$ sudo apt-get upgrade

#add external repo for newest php
$ sudo add-apt-repository ppa:ondrej/php

#reload package lists
$ sudo apt-get update

#install apache web server
$ sudo apt-get install -y apache2

#install php7.2 and it's modules
$ sudo apt-get install -y php7.2 libapache2-mod-php7.2 php7.2-cli php7.2-common php7.2-mbstring php7.2-gd php7.2-intl php7.2-xml php7.2 mysql php7.2-zip

#install mysql web server
$ sudo apt-get install mysql-server

#install composer
$ sudo apt-get install composer
```


2. EDIT FILE /etc/apache2/sites-enabled/000-default.conf
```
CHANGE

    DocumentRoot /var/www/html
    
TO

    DocumentRoot /var/www/html/aac/public
    <Directory /var/www/html/aac/public>
        AllowOverride All
        Order Allow,Deny
        Allow from All
    </Directory>
    
```


3. Download and extract fmAAC to web server root directory
```shell
#navigate to web server root directory
$ cd /var/www/html

#download FlatMannerAAC
$ wget https://github.com/Gh05t-PL/FlatMannerAAC/archive/master.zip

#create aac directory
$ mkdir aac

#extract master.zip
$ 7z x master.zip

#move all files to aac directory
$ mv FlatMannerAAC-master/{.,}* aac
```


4. Download dependencies for Symfony framework and make it runnable
```shell
#install all the dependencies
$ composer install
 
#set rights for files recursively (if not working use sudo)
$ chmod 777 -R /var/www/html/aac

#enable mod_rewrite in apache
$ sudo a2enmod rewrite
 
#IF YOU HAVE OTHER PHP INSTALLATION YOU MUST DISABLE IT WITH
    $ sudo a2dismod php{phpVersion}
#FOR EXAMPLE
    $ sudo a2dismod php7.0
#AND THEN ENABLE PHP7.2
    $ sudo a2enmod php7.2
```


5. Install FlatMannerAAC
```shell
#run FlatMannerAAC installation script
$ bash install.sh
```
PROCEED WITH CAUTION!
IN CASE OF ERROR GO TO

https://otland.net/threads/fmaac-flatmanneraac-mvc-symfony4.258502/


CRON TASKS LOGGING INTO aac/CRON/crons.log
INSTALLATION LOGGING INTO aac/CRON/install.log


Tested with TFS 0.3.6 && TFS 0.4 && TFS 1.2

