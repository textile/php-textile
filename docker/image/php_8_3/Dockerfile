FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    bash \
    git \
    libz-dev \
    zip \
    wget

RUN pecl install xdebug-3.3.1

RUN docker-php-ext-enable xdebug

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /app
