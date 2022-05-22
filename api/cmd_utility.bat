echo off
php artisan config:cache

php artisan view:clear

php artisan cache:clear

php artisan route:cache

# set /p DUMMY=Hit ENTER to continue...


