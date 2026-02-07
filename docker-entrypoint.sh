#!/bin/bash
set -e

echo "===== FastInsta Startup ====="
echo "PORT: ${PORT:-8080}"
echo "============================="

# Run migrations if DB is configured
if [ -n "$DB_HOST" ]; then
    echo "Running migrations..."
    php artisan migrate --force || echo "Migration warning: $?"
fi

# Clear and cache config
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Start PHP's built-in server (simpler and more reliable than Apache for Railway)
echo "Starting PHP server on 0.0.0.0:${PORT:-8080}..."
exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
