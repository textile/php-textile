FROM php:7.4-cli

RUN apt-get update && apt-get install -y \
    bash \
    git \
    libzip-dev \
    unzip \
    zlib1g-dev

RUN pecl install xdebug-3.1.6

RUN docker-php-ext-enable xdebug

COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

WORKDIR /app
