## Start project
```
composer install
php artisan key:generate
php artisan jwt:secret
php artisan migrate
composer dump-autoload
php artisan db:seed
```

## Local
```
web: rmt.test
api: rmt.test/api
```