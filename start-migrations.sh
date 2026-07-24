#!/bin/bash

echo "Starting Royal Crest Hotel..."

# Wait for DB
sleep 3

# Run migrations
php artisan migrate --force 2>&1 || echo "Migration warning - continuing"

# Start server
echo "Starting server on port $PORT..."
exec php artisan serve --host=0.0.0.0 --port=$PORT
