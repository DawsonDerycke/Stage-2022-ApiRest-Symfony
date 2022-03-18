# php-fpm
FROM php:7.4-fpm

CMD ["php-fpm"]

WORKDIR /var/www/html/

RUN sed -i '/bullseye-updates/d' /etc/apt/sources.list

#RUN apk add shadow && usermod -u 1000 www-data && groupmod -g 1000 www-data
RUN docker-php-ext-install pdo_mysql && \
    docker-php-ext-enable pdo_mysql

RUN docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install opcache

#COPY . .

# Override with custom opcache settings
# COPY config/opcache.ini $PHP_INI_DIR/conf.d/

RUN pecl install xdebug xhprof && docker-php-ext-enable xdebug xhprof;

EXPOSE 9000