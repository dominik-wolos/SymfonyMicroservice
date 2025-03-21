ARG PHP_VERSION=8.3.3
ARG NGINX_VERSION=1.21
ARG ALPINE_VERSION=3.19
ARG COMPOSER_VERSION=2.4
ARG PHP_EXTENSION_INSTALLER_VERSION=latest

FROM composer:${COMPOSER_VERSION} AS composer

FROM mlocati/php-extension-installer:${PHP_EXTENSION_INSTALLER_VERSION} AS php_extension_installer

FROM php:${PHP_VERSION}-fpm-alpine${ALPINE_VERSION} AS base

RUN apk add --no-cache \
        acl \
        file \
        gettext \
        unzip \
    ;

COPY --from=php_extension_installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions apcu exif gd intl pdo_mysql opcache zip sockets && docker-php-ext-enable pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY docker/php/prod/php.ini        $PHP_INI_DIR/php.ini
COPY docker/php/prod/opcache.ini    $PHP_INI_DIR/conf.d/opcache.ini

COPY config/preload.php /srv/app/config/preload.php

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1
RUN set -eux; \
    composer clear-cache
ENV PATH="${PATH}:/root/.composer/vendor/bin"

WORKDIR /srv/app

ENV APP_ENV=prod

COPY composer.* ./
RUN set -eux; \
    composer install --prefer-dist --no-autoloader --no-interaction --no-scripts --no-progress --no-dev; \
    composer clear-cache

COPY .env .env.prod .env.local ./
COPY bin bin/
COPY config config/
COPY public public/
COPY src src/

RUN set -eux; \
    mkdir -p var/cache var/log; \
    composer dump-autoload --classmap-authoritative; \
    APP_SECRET='' composer run-script post-install-cmd; \
    chmod +x bin/console; sync

VOLUME /srv/app/var

COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]

FROM base AS app_php_prod

FROM nginx:${NGINX_VERSION}-alpine AS app_nginx

COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/

WORKDIR /srv/app

COPY --from=base        /srv/app/public public/

FROM app_php_prod AS app_php_dev

COPY docker/php/dev/php.ini        $PHP_INI_DIR/php.ini
COPY docker/php/dev/opcache.ini    $PHP_INI_DIR/conf.d/opcache.ini

WORKDIR /srv/app

ENV APP_ENV=dev

COPY .env.test ./

RUN set -eux; \
    composer install --prefer-dist --no-autoloader --no-interaction --no-scripts --no-progress; \
    composer clear-cache
