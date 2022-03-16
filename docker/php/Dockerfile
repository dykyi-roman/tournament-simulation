FROM php:8.1.0-fpm-buster

WORKDIR /var/www/html/code

RUN apt-get update && apt-get install -y \
        libzip-dev \
        libmcrypt-dev \
        libcurl4-openssl-dev \
        libssl-dev \
	    libonig-dev \
        libicu-dev \
        libevent-dev \
        uuid-dev \
        librabbitmq-dev \
        libssh-dev \
        libgeoip-dev \
        libmemcached-dev \
        openssl \
        openssh-server \
        nano \
        && rm -rf /var/lib/apt/lists/*

# read: https://github.com/mlocati/docker-php-extension-installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apt-get install -y $PHPIZE_DEPS

# PHP Extensions
RUN install-php-extensions xdebug mbstring amqp apcu bcmath calendar @composer decimal gmp intl opcache redis zip bcmath pdo pdo_pgsql