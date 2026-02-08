#!/bin/bash
set -e

echo "=========================================="
echo "FastInsta Production Startup"
echo "=========================================="
echo "PORT: ${PORT:-8080}"
echo "DB_CONNECTION: ${DB_CONNECTION:-sqlite}"
echo "APP_ENV: ${APP_ENV:-production}"
echo "=========================================="

cd /var/www/html

# Create SQLite database if needed
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    echo "Setting up SQLite database..."
    touch database/database.sqlite
    chmod 777 database/database.sqlite
fi

# Create storage link
echo "Creating storage link..."
php artisan storage:link 2>/dev/null || echo "Storage link already exists"

# Ensure storage directories exist and are writable
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p storage/logs
mkdir -p bootstrap/cache
chmod -R 777 storage bootstrap/cache database 2>/dev/null || true

# Run migrations
echo "Running migrations..."
php artisan migrate --force || echo "Migration completed with warnings"

# Clear and cache
echo "Caching configuration..."
php artisan config:clear
php artisan route:clear  
php artisan view:clear

echo "=========================================="
echo "Starting Laravel server on 0.0.0.0:${PORT:-8080}"
echo "=========================================="

# Start PHP's built-in server pointing to public directory
exec php -S 0.0.0.0:${PORT:-8080} -t public
