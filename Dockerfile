FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libzip-dev libsqlite3-dev zip unzip git curl nodejs npm \
    && docker-php-ext-install zip pdo pdo_sqlite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

WORKDIR /var/www/html
COPY . .

# Copie le .env.production comme .env
COPY .env.production .env

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run production
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
CMD ["/entrypoint.sh"]