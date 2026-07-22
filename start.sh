#!/bin/bash

# Exit on error
set -e

echo "Starting Royal Crest Hotel deployment..."

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Start PHP built-in server
echo "Starting PHP server on port $PORT..."
php -S 0.0.0.0:$PORT -t public/ public/index.php
