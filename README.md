# Tell Composer to use your local path
composer config repositories.pranavsy path ../path/to/pranavsy-visitcounter
composer require pranavsy/visitcounter:*@dev

# Publish & run migration
php artisan vendor:publish --tag=visitcounter
php artisan migrate
