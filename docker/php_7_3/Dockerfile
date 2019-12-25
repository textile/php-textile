FROM composer

FROM php:7.3-cli

RUN apt-get update && apt-get install -y \
  bash \
  git \
  unzip \
  zlib1g-dev \
  libzip-dev

RUN docker-php-ext-install zip

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1

ADD . /app

RUN cd /app && \
    rm -rf vendor composer.lock && \
    composer install && \
    cd -

WORKDIR /app
