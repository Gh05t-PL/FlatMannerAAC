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
configvar="\n###> symfony/framework-bundle ###\nAPP_ENV=$env\nAPP_SECRET=$secret\n#TRUSTED_PROXIES=127.0.0.1,127.0.0.2\n#TRUSTED_HOSTS=localhost,example.com\n###< symfony/framework-bundle ###\n\n###> symfony/swiftmailer-bundle ###\n# For Gmail as a transport, use: 'gmail://username:password@localhost'\n# For a generic SMTP server, use: 'smtp://localhost:25?encryption=&auth_mode='\n# Delivery is disabled by default via 'null://localhost'\nMAILER_URL=null://localhost\n###< symfony/swiftmailer-bundle ###\n\n###> doctrine/doctrine-bundle ###\n# Format described at http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url\n# For an SQLite database, use: 'sqlite:///%kernel.project_dir%/var/data.db'\n# Configure your db driver and server_version in config/packages/doctrine.yaml\nDATABASE_URL=mysql://$DB_USER:$DB_PASS@$DB_HOST:3306/$DB_NAME\n###< doctrine/doctrine-bundle ###"

echo "Saving config to .env file"
(echo -e $configvar > .env)

echo
echo

echo "======================="
echo "= Configuration Done! ="
echo "======================="


echo
echo

echo "=============================================="
echo "=       Install Extensions? 'y' or 'n'        "
echo "= Remember do not install it 2 times for now ="
echo "=============================================="
read installExt

if [[ $installExt == "y" ]]; then



echo
echo "==================================="
echo "= Installing CRON for PowerGamers ="
echo "==================================="
(crontab -l > tempCron)

echo "FULL PATH TO powergamers.php:"
read path

while [ ! -e $path ]
do
  echo "FILE NOT FOUND! Please provide proper path"
done

(echo "00 00 * * * php $path" >> tempCron)
(crontab tempCron)
echo "CRON ADDED!"
(rm tempCron)
echo "REMOVED CRON TEMPORARY FILES. Good Luck!"

# echo
# echo

# echo "=================================="
# echo "= Installing CRON for Statistics ="
# echo "=================================="


elif [[ $installExt == "n" ]]; then
  echo 'EXITING....'
  echo 'HAVE FUN!!'
  exit 0
else 
  echo 'Invalid input exiting...'
  exit 1
fi