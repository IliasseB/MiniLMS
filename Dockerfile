FROM php:7.4-apache

# Extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl nodejs npm \
    && docker-php-ext-install zip pdo pdo_sqlite

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Config Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# Copie du projet
WORKDIR /var/www/html
COPY . .

# Installation des dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Installation des dépendances JS et build
RUN npm install && npm run production

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Génère la clé Laravel
RUN php artisan key:generate --force

EXPOSE 80