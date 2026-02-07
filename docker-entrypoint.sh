#!/bin/bash
set -e

echo "=========================================="
echo "FastInsta Production Startup"
echo "=========================================="
echo "PORT: ${PORT:-8080}"
echo "DB_HOST: ${DB_HOST:-not set}"
echo "APP_ENV: ${APP_ENV:-not set}"
echo "=========================================="

cd /var/www/html

# Create storage link
echo "Creating storage link..."
php artisan storage:link 2>/dev/null || echo "Storage link already exists"

# Run migrations if DB is configured
if [ -n "$DB_HOST" ] && [ "$DB_HOST" != "not set" ]; then
    echo "Running migrations..."
    php artisan migrate --force || echo "Migration warning: check DB credentials"
else
    echo "Skipping migrations (no DB_HOST configured)"
fi

# Clear and cache
echo "Caching configuration..."
php artisan config:cache 2>/dev/null || php artisan config:clear
php artisan route:cache 2>/dev/null || php artisan route:clear
php artisan view:cache 2>/dev/null || php artisan view:clear

# Ensure storage directories exist and are writable
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p storage/logs
mkdir -p bootstrap/cache
chmod -R 777 storage bootstrap/cache 2>/dev/null || true

echo "=========================================="
echo "Starting Laravel server on 0.0.0.0:${PORT:-8080}"
echo "=========================================="

# Start PHP's built-in server pointing to public directory
exec php -S 0.0.0.0:${PORT:-8080} -t public
