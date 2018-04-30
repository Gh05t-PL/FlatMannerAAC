#!/bin/bash
set -e

echo
echo


echo "============================="
echo "= Installing fmAAC by Ghost ="
echo "============================="

echo
echo

echo 'Environment? ("prod" or "dev")'
read env
echo
echo 'Secret key? ("recommended length is around 32 characters.")'
read secret

#  \/(\w+\/)+powergamers.php
# if file is in cron folder then install else give path \/(\w+\/)+powergamers.php

while [ $(echo -n $secret | wc -m) -lt 10 ]
do
  echo
  echo 'Secret key is shorter than 10 characters ("recommended length is around 32 characters.")'
  read secret
done

echo
echo

echo "=============================="
echo "= DataBase Connection Config ="
echo "=============================="

echo
echo

echo DB_USER:
read DB_USER
echo
echo DB_PASS:
read DB_PASS
echo
echo DB_NAME:
read DB_NAME
echo
echo 'DB_HOST: (for example: "127.0.0.1")'
read DB_HOST

echo
aacConfig="\n###> symfony/framework-bundle ###\nAPP_ENV=$env\nAPP_SECRET=$secret\n#TRUSTED_PROXIES=127.0.0.1,127.0.0.2\n#TRUSTED_HOSTS=localhost,example.com\n###< symfony/framework-bundle ###\n\n###> symfony/swiftmailer-bundle ###\n# For Gmail as a transport, use: 'gmail://username:password@localhost'\n# For a generic SMTP server, use: 'smtp://localhost:25?encryption=&auth_mode='\n# Delivery is disabled by default via 'null://localhost'\nMAILER_URL=null://localhost\n###< symfony/swiftmailer-bundle ###\n\n###> doctrine/doctrine-bundle ###\n# Format described at http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url\n# For an SQLite database, use: 'sqlite:///%kernel.project_dir%/var/data.db'\n# Configure your db driver and server_version in config/packages/doctrine.yaml\nDATABASE_URL=mysql://$DB_USER:$DB_PASS@$DB_HOST:3306/$DB_NAME\n###< doctrine/doctrine-bundle ###"

cronConfig="<?php\n\$cfg = ['database' => '$DB_NAME','user' => '$DB_USER','password' => '$DB_PASS','host' => '$DB_HOST'];"

echo "Saving config to .env file"
(echo -e $aacConfig > .env)
(echo -e $cronConfig > CRON/config.php)
echo
echo

echo "======================="
echo "= Configuration Done! ="
echo "======================="


echo
echo




echo "=============================================="
echo "=       Install Extensions? 'y' or 'n'       ="
echo "= Remember do not install it 2 times for now ="
echo "=============================================="
read installExt

if [[ $installExt == "y" ]]; then



echo
(crontab -l > tempCron)



if  ( grep -q "powergamers" tempCron ; ) then
  echo "Power Gamers has previously been installed"
  echo "Exiting...."
  (rm tempCron)
  exit 0
fi
echo
echo "==================================="
echo "= Installing CRON for PowerGamers ="
echo "==================================="


# ?
if [[ ! -e CRON/powergamers.php ]] ; then

  echo "FILE NOT FOUND! Provide FULL PATH TO powergamers.php:"
  read path

  while [ ! -e $path/powergamers.php ]
  do
    echo "FILE NOT FOUND! Please provide proper path"
    read path
  done

else
  path="${PWD}/CRON"
fi



(echo -e "\n# powergamers\n0 0 * * * php $path/powergamers.php >> $path/crons.log" >> tempCron)

# ?

# ?
if  ( grep -q "fmaacStatistics" tempCron ; ) then
  echo "Statistics has previously been installed"
  echo "Exiting...."
  (rm tempCron)
  exit 0
fi
echo
echo "=================================="
echo "= Installing CRON for Statistics ="
echo "=================================="

if [[ ! -e CRON/statistics.php ]] ; then

  echo "FILE NOT FOUND! Provide FULL PATH TO statistics.php:"
  read path

  while [ ! -e $path/statistics.php ]
  do
    echo "FILE NOT FOUND! Please provide proper path"
    read path
  done

else
  path="${PWD}/CRON"
fi

(echo -e "\n# fmaacStatistics\n0 */1 * * * php $path/statistics.php >> $path/crons.log" >> tempCron)
# ?
(crontab tempCron)
echo "[OK]CRON ADDED!"
(rm tempCron)
echo "[OK]REMOVED CRON TEMPORARY FILES. Good Luck!"



elif [[ $installExt == "n" ]]; then
  echo 'EXITING....'
  echo 'HAVE FUN!!'
  exit 0
else 
  echo 'Invalid input exiting...'
  exit 1
fi