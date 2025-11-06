FROM php:8.2-apache
RUN apt-get update && apt-get install -y git unzip libicu-dev libzip-dev zip \
    && docker-php-ext-install intl pdo pdo_mysql opcache \
    && a2enmod rewrite

WORKDIR /var/www/html
COPY . .
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --no-scripts --no-progress
COPY ./docker/vhost.conf /etc/apache2/sites-available/000-default.conf
EXPOSE 80
CMD ["apache2-foreground"]