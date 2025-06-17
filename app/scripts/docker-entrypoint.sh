#!/bin/bash
set -e

php artisan config:clear
php artisan migrate --force
exec php artisan serve --host=0.0.0.0 --port=$PORT