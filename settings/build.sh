#!/bin/bash
# Build script to move conf files and build laravel

# Move apache conf file
echo "Moving apache conf file"
sudo cp /var/www/settings/apache2.conf /etc/apache2/apache2.conf

# Move site available directory
echo "Moving sites-available directory"
sudo cp -R /var/www/settings/sites-available /etc/apache2/

# Move site available directory
echo "Moving php.ini file"
sudo cp /var/www/settings/php.ini /etc/php5/cli/

# Move site available directory
echo "Moving php.ini file for php-fpm"
sudo cp /var/www/settings/php-fpm/php.ini /etc/php5/fpm/

echo "Restart apache"
sudo service apache2 restart

# Move site available directory
echo "Moving mongodb conf file"
sudo cp /var/www/settings/mongodb.conf /etc/

echo "Restart mongodb"
sudo service mongodb restart

# Build laravel
echo "Building laravel"
echo "Moving into /var/www/"
cd /var/www/
echo "Downloading composer"
curl -sS https://getcomposer.org/installer | php
echo "Building laravel"
php composer.phar install
echo "Migrarting database"
php artisan migrate
echo "Seeding the database"
php artisan db:seed