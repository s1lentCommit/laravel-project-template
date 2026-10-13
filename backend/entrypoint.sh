
#!/bin/sh

set -e

APP_DIR="${APP_DIR:-/var/www}"

cd "$APP_DIR"

# 1. Prepare Laravel writable directories
echo "Preparing Laravel writable directories..."

mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R u+rwX,g+rwX storage bootstrap/cache

# 2. Wait for MySQL
until nc -z db 3306; do
    echo "Waiting for database..."
    sleep 2
done

echo "Database is available."

# 3. Install Composer dependencies if missing
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

# 4. Check application key
if ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
    if [ "$APP_ENV" = "production" ]; then
        echo "ERROR: APP_KEY is missing in production."
        exit 1
    else
        echo "Generating application key..."
        php artisan key:generate
    fi
fi

# 5. Run migrations
echo "Running migrations..."
php artisan migrate --force

# 6. Cache production configuration
if [ "$APP_ENV" = "production" ]; then
    echo "Caching Laravel configuration..."

    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# 7. Ensure final permissions
chown -R www-data:www-data storage bootstrap/cache
chmod -R u+rwX,g+rwX storage bootstrap/cache


# 8. Start PHP-FPM
echo "Starting PHP-FPM..."
exec php-fpm
