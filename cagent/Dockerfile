FROM php:8.2-cli

# Instala dependências do PHP
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libonig-dev libffi-dev \
    && docker-php-ext-install ffi

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
