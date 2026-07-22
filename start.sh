#!/bin/bash

echo "Starting Royal Crest Hotel deployment..."

# Run migrations (don't exit on error for migrations)
echo "Running database migrations..."
php artisan migrate --force || echo "Migration warning (might be normal if tables exist)"

# Clear caches
php artisan config:clear
php artisan cache:clear

# Start Laravel development server
echo "Starting Laravel server on 0.0.0.0:$PORT..."
exec php artisan serve --host=0.0.0.0 --port=$PORT --no-reload
