FROM php:7.1-fpm

RUN apt-get update \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli \
    && docker-php-ext-install pcntl \
    && docker-php-ext-enable pcntl \
    && docker-php-ext-install json \
    && docker-php-ext-enable json

# Redirect fpm logs to stdout and stderr so they are forwarded to the docker log collector
RUN ln -sf /dev/stdout /usr/local/var/log/fpm-access.log
RUN ln -sf /dev/stderr /usr/local/var/log/fpm-error.log

