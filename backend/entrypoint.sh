#!/bin/sh

until nc -z db 3306; do
    echo "Waiting for database..."
    sleep 2
done

composer install

php artisan key:generate --force || true

php artisan migrate --force

if [ "$APP_ENV" = "production" ]; then
    php artisan config:clear
    php artisan cache:clear
    php artisan config:cache
    php artisan route:cache
fi

chmod -R 777 storage bootstrap/cache

exec php-fpm
