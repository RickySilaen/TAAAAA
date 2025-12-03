#!/bin/bash

echo "Running post-deployment tasks..."

# Run migrations
php artisan migrate --force

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link if not exists
php artisan storage:link

# Set proper permissions
chmod -R 775 storage bootstrap/cache

echo "Post-deployment tasks completed!"
