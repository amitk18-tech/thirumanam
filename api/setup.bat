@echo off
REM Setup script for Laravel project

echo Installing Composer dependencies...
composer install

echo Generating application key...
php artisan key:generate

echo Running migrations...
php artisan migrate

echo Seeding database...
php artisan db:seed

echo Clearing cache...
php artisan cache:clear


echo Linking storage...
php artisan storage:link
echo Setup complete!