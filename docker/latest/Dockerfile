FROM composer

FROM php:7.4-cli

RUN apt-get update && apt-get install -y \
  bash \
  git \
  unzip \
  zlib1g-dev \
  libzip-dev

RUN docker-php-ext-install zip

RUN pecl install xdebug

RUN docker-php-ext-enable xdebug

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /app
