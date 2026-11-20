FROM php:8.6-cli

RUN apt-get update && apt-get install -y \
    bash \
    git \
    libonig-dev \
    libz-dev \
    zip \
    wget

RUN docker-php-ext-configure mbstring && docker-php-ext-install mbstring

COPY --from=composer:2.11 /usr/bin/composer /usr/bin/composer
COPY --from=ghcr.io/php/pie:1.5-bin /pie /usr/bin/pie

RUN pie install xdebug/xdebug:dev-master && docker-php-ext-enable xdebug

RUN mkdir -p /.config/psysh && chmod 777 /.config/psysh

WORKDIR /app
