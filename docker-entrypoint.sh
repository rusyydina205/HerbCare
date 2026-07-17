#!/bin/bash
set -e

# Run Laravel database migrations
# This will automatically create your tables in Render's database when it starts
php artisan migrate --force

# Start the Apache web server in the foreground
apache2-foreground
