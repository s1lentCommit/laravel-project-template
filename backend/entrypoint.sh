#!/bin/sh

set -e

APP_DIR="${APP_DIR:-/var/www}"

cd "$APP_DIR"

until nc -z db 3306; do
    echo "Waiting for database..."
    sleep 2
done

echo "Database is available."

if [ ! -f vendor/autoload.php ]; then
    echo "Installing Composer dependencies..."

    if [ "$APP_ENV" = "production" ]; then
        composer install \
            --no-dev \
            --optimize-autoloader \
            --no-interaction
    else
        composer install
    fi
fi

if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
    if [ "$APP_ENV" = "production" ]; then
        echo "ERROR: APP_KEY is missing in production."
        exit 1
    else
        echo "Generating application key..."
        php artisan key:generate
    fi
fi

echo "Running migrations..."
php artisan migrate --force

if [ "$APP_ENV" = "production" ]; then
    echo "Caching Laravel configuration..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

chmod -R 775 storage bootstrap/cache

echo "Starting PHP-FPM..."

exec php-fpm
