ARG PHP_VERSION=7.2
FROM php:${PHP_VERSION}-cli

RUN pecl install uopz || exit 0
RUN pecl install uopz-6.1.2 || exit 0
RUN docker-php-ext-enable uopz
RUN echo "uopz.exit=1" >> /usr/local/etc/php/conf.d/docker-php-ext-uopz.ini

ARG COVERAGE
RUN if [ "$COVERAGE" = "pcov" ]; then pecl install pcov && docker-php-ext-enable pcov; fi

RUN apt update && apt install -y git zip
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app
