ARG PHP_VERSION=7.3
FROM php:${PHP_VERSION}-cli

COPY install-uopz.sh /tmp/
RUN /tmp/install-uopz.sh
RUN docker-php-ext-enable uopz
RUN echo "uopz.exit=1" >> /usr/local/etc/php/conf.d/docker-php-ext-uopz.ini

ARG COVERAGE
RUN if [ "$COVERAGE" = "pcov" ]; then pecl install pcov && docker-php-ext-enable pcov; fi

RUN apt update && apt install -y git zip
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app
RUN git config --global --add safe.directory /app
