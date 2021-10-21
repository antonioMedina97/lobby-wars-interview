FROM php:8.0-fpm

RUN apt-get update \
    && apt-get remove -y mariadb-server mariadb-client \
    && apt-get install -y \
    git \
    libssl-dev \
    default-mysql-client \
    libmcrypt-dev \
    libicu-dev \
    libpq-dev \
    libjpeg62-turbo-dev \
    libjpeg-dev  \
    libpng-dev \
    zlib1g-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    unzip

RUN docker-php-ext-install \
    gd \
    intl \
    mbstring \
    pdo \
    pdo_mysql \
    mysqli \
    zip

WORKDIR /opt/app/

COPY ./ /opt/app/

RUN curl -sS https://getcomposer.org/installer | php && \
 mv composer.phar /usr/local/bin/composer && \
 composer install


