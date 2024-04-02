FROM php:8.3-fpm-alpine

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"&& \
    echo "upload_max_filesize  = 90M" > "$PHP_INI_DIR/conf.d/upload_max_filesize.ini" &&\
    echo "memory_limit = 4G" > "$PHP_INI_DIR/conf.d/memory_limit.ini" &&\
    echo "max_execution_time = 180" > "$PHP_INI_DIR/conf.d/max_execution_time.ini" &&\
    echo "post_max_size = 110M" > "$PHP_INI_DIR/conf.d/post_max_size.ini"

RUN apk add --no-cache git

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions opcache apcu intl pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer
