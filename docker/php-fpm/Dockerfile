FROM php:7.4-fpm-alpine

RUN apk add --update --no-cache oniguruma-dev $PHPIZE_DEPS; \
    pecl install xdebug && docker-php-ext-enable xdebug; \
    docker-php-ext-install mbstring pdo_mysql;

RUN echo 'xdebug.profiler_enable=0' >> /usr/local/etc/php/php.ini;
RUN echo 'xdebug.profiler_enable_trigger=1' >> /usr/local/etc/php/php.ini;
RUN echo 'xdebug.profiler_output_dir=/var/www/html/xdebug/' >> /usr/local/etc/php/php.ini;
RUN mkdir /xdebug/ && chmod -R 777 /xdebug/;
RUN echo 'xdebug.idekey=PHPSTORM' >> /usr/local/etc/php/php.ini;
RUN echo 'xdebug.remote_port=9000' >> /usr/local/etc/php/php.ini;
RUN echo 'xdebug.remote_connect_back=0' >> /usr/local/etc/php/php.ini;
RUN echo 'xdebug.remote_host=docker.for.mac.localhost' >> /usr/local/etc/php/php.ini;
RUN echo 'xdebug.remote_enable=1' >> /usr/local/etc/php/php.ini;
RUN echo 'xdebug.remote_handler="dbgp"' >> /usr/local/etc/php/php.ini;

ARG COMPOSER_VERSION=1.10.8
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV PHP_IDE_CONFIG "serverName=docker-server"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer --version=${COMPOSER_VERSION};

RUN composer global require hirak/prestissimo

WORKDIR /app
