#!/bin/bash
set -e

touch /var/www/html/database/database.sqlite
chown www-data:www-data /var/www/html/database/database.sqlite

echo "==> Lancement des migrations..."
php artisan migrate:fresh --seed --force
echo "==> Migrations terminées"

apache2-foreground