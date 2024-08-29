FROM php:8.4-rc-cli

RUN apt-get update && apt-get install -y \
    bash \
    git \
    libz-dev \
    zip \
    wget

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /app
