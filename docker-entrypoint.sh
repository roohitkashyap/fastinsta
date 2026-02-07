#!/bin/bash
set -e

# Handle PORT variable for Apache
sed -i "s/Listen 80/Listen ${PORT:-80}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT:-80}/g" /etc/apache2/sites-enabled/000-default.conf

# Run migrations (force)
php artisan migrate --force

# Cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache in foreground
exec apache2-foreground
