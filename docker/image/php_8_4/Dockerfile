FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    bash \
    git \
    libz-dev \
    zip \
    wget

RUN pecl install xdebug-3.4.0beta1

RUN docker-php-ext-enable xdebug

COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

WORKDIR /app
