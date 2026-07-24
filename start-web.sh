#!/bin/bash
echo "Starting deployment..."
# Make sure we're in the right directory
cd /app || exit 1
# Wait a moment for database to be ready
sleep 2
# Run migrations
php artisan migrate --force --isolated --no-interaction 2>&1 || true
# Clear old cache then rebuild so Railway env vars are picked up
php artisan config:clear 2>&1 || true
php artisan config:cache 2>&1 || true
php artisan route:cache 2>&1 || true
php artisan view:cache 2>&1 || true
# Start server on Railway's PORT
exec php -S 0.0.0.0:${PORT:-8080} -t public/ 2>&1
