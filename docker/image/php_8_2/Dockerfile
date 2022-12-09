FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    bash \
    git \
    libz-dev \
    zip \
    wget

RUN pecl install xdebug-3.2.0

RUN docker-php-ext-enable xdebug

COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

WORKDIR /app
