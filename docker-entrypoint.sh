#!/bin/bash
set -e

# Handle PORT variable for Apache
echo "Configuring Apache to listen on PORT: ${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT:-80}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT:-80}>/g" /etc/apache2/sites-available/000-default.conf
sed -i "s/:80/:${PORT:-80}/g" /etc/apache2/sites-enabled/000-default.conf

# Force disable conflicting MPMs and enable prefork (required for PHP)
a2dismod -f mpm_event || true
a2dismod -f mpm_worker || true
a2enmod mpm_prefork || true

# Check if DB is configured before running migrations
if [ -z "$DB_HOST" ]; then
    echo "WARNING: DB_HOST is not set. Skipping migrations."
    # Create simple sqlite file if needed or just skip
else
    # Run migrations (force)
    echo "Running migrations..."
    php artisan migrate --force || echo "Migration failed! Check DB credentials."
fi

# Cache config
php artisan config:clear
php artisan route:clear
php artisan view:clear
# We clear cache first to ensure env vars are picked up

# Start Apache in foreground
exec apache2-foreground
