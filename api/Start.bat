REM Step 1: Generate application key
echo Generating application key...
php artisan key:generate

REM Step 2: Refresh the database and run seeders
echo Refreshing the database and running seeders...
php artisan migrate:fresh --seed

REM Step 3: Clear cache, config, route, and view
echo Clearing application cache...
php artisan cache:clear

echo Clearing configuration cache...
php artisan config:clear

echo Clearing route cache...
php artisan route:clear

echo Clearing view cache...
php artisan view:clear

REM Step 4: Start the Laravel development server
echo Starting the Laravel development server...
php artisan serve

REM Script end message
echo Laravel project setup complete! Server running at http://127.0.0.1:8000