#!/bin/bash
set -e

touch /var/www/html/database/database.sqlite
chown www-data:www-data /var/www/html/database/database.sqlite

php artisan migrate:fresh --seed --force

apache2-foreground