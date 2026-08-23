FROM php:8.5-cli

RUN apt-get update && apt-get install -y \
    bash \
    git \
    libz-dev \
    zip \
    wget

RUN pecl install xdebug-3.5.0

RUN docker-php-ext-enable xdebug

COPY --from=composer:2.10 /usr/bin/composer /usr/bin/composer

WORKDIR /app
