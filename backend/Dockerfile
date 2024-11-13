FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
        git zip unzip \
        libzip-dev libicu-dev libxml2-dev \
        libpq-dev libcurl4-gnutls-dev libssl-dev \
        build-essential libonig-dev default-mysql-client

RUN docker-php-ext-install intl pdo pdo_mysql zip curl mbstring soap  xml

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/app

COPY ./backend ./

RUN chmod -R 777 ./storage

EXPOSE 9000

CMD ["php-fpm"]