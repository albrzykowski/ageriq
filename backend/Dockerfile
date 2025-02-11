FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip
RUN docker-php-ext-install zip# INSTALL AND UPDATE COMPOSER
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer self-updateWORKDIR /usr/src/myapp
COPY . .
RUN composer install
CMD php public/index.php