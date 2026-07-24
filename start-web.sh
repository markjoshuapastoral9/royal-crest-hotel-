#!/bin/bash
echo "Starting deployment..."
cd /app || exit 1

# Wait for database to be ready
sleep 2

# Run migrations
php artisan migrate --force --isolated --no-interaction 2>&1 || true

# Clear all caches (do NOT cache config on Railway - env vars must be read fresh)
php artisan config:clear 2>&1 || true
php artisan cache:clear 2>&1 || true
php artisan view:clear 2>&1 || true
php artisan route:clear 2>&1 || true

# Start server on Railway's PORT
exec php -S 0.0.0.0:${PORT:-8080} -t public/ 2>&1
