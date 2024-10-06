#!/bin/bash

# Exit immediately if a command exits with a non-zero status.
set -e

# Run Composer to install dependencies, ignoring platform requirements
echo "Running composer install..."
composer install --ignore-platform-reqs

# Wait for the database to be ready (optional, if needed)
# sleep 10

# Run migrations and seed the database
echo "Running migrations and seeding..."
php artisan migrate --seed

# Regenerate the autoload files
echo "Dumping autoload..."
composer dump-autoload

# Generate the application key
echo "Generating application key..."
php artisan key:generate

# Check if Passport keys exist, if not, generate them
if [ ! -f storage/oauth-private.key ] || [ ! -f storage/oauth-public.key ]; then
    echo "Generating Passport keys..."
    php artisan passport:keys
else
    echo "Passport keys already exist, skipping generation."
fi

# Check if a personal access client exists, if not, create one using DB facade
PERSONAL_CLIENT_EXISTS=$(php artisan tinker --execute "echo DB::table('oauth_clients')->where('personal_access_client', 1)->exists() ? '1' : '0';")

if [ "$PERSONAL_CLIENT_EXISTS" -eq "0" ]; then
    echo "Creating personal access client..."
    php artisan passport:client --personal
else
    echo "Personal access client already exists, skipping creation."
fi

# Execute the main container process (CMD in Dockerfile)
exec "$@"
