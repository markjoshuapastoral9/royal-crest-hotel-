#!/bin/bash

echo "==================================="
echo "Royal Crest Hotel - Starting..."
echo "==================================="
echo "PORT: $PORT"
echo "APP_ENV: $APP_ENV"
echo ""

# Run database migrations
echo "Running migrations..."
php artisan migrate --force --no-interaction 2>&1 || echo "Migrations completed or already up to date"
echo ""

# Clear and optimize
echo "Optimizing application..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize
echo ""

# Start the server
echo "Starting web server on port $PORT..."
echo "==================================="

# Use PHP built-in server with proper document root
php -S 0.0.0.0:${PORT} -t public 2>&1
