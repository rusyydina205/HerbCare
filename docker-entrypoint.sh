#!/bin/bash
set -e

# Run Laravel database migrations & seeders
php artisan migrate --force
php artisan db:seed --force

# Start the Apache web server in the foreground
apache2-foreground
