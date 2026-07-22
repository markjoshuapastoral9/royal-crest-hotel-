#!/bin/bash
set -e

echo "=========================================="
echo "Starting Royal Crest Hotel Application"
echo "=========================================="

# Wait for database to be ready
echo "Waiting for database connection..."
until php artisan migrate:status 2>&1 | grep -q "Migration table created successfully\|Migration name"; do
    echo "Database not ready yet, waiting 2 seconds..."
    sleep 2
done

echo "Database connection established!"
echo ""

# Run migrations
echo "Running database migrations..."
php artisan migrate --force --isolated

echo ""
echo "Migration completed!"
echo ""

# Check migration status
echo "Current migration status:"
php artisan migrate:status

echo ""
echo "=========================================="
echo "Starting Laravel Server on port $PORT"
echo "=========================================="

# Start the application
exec php artisan serve --host=0.0.0.0 --port=$PORT --no-reload
