#!/bin/sh

set -e

cd /workspace/backend

until nc -z db 3306; do
    echo "Waiting for database..."
    sleep 2
done

echo "Database is available."

if [ ! -f vendor/autoload.php ]; then
    echo "Installing Composer dependencies..."
    composer install
fi

if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
    echo "Generating application key..."
    php artisan key:generate
fi

php artisan migrate --force

if [ "$APP_ENV" = "production" ]; then
    php artisan config:clear
    php artisan cache:clear
    php artisan config:cache
    php artisan route:cache
fi

chmod -R 775 storage bootstrap/cache

exec php-fpm
