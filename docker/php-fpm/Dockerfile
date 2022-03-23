FROM mcr.microsoft.com/mssql-tools as mssql
# php-fpm
FROM php:7.4-fpm-alpine

CMD ["php-fpm"]

WORKDIR /var/www/html/

COPY --from=mssql /opt/microsoft/ /opt/microsoft/
COPY --from=mssql /opt/mssql-tools/ /opt/mssql-tools/
COPY --from=mssql /usr/lib/libmsodbcsql-13.so /usr/lib/libmsodbcsql-13.so

# Download the ODBC package(s)
RUN curl -O https://download.microsoft.com/download/e/4/e/e4e67866-dffd-428c-aac7-8d28ddafb39b/msodbcsql17_17.7.2.1-1_amd64.apk
RUN curl -O https://download.microsoft.com/download/e/4/e/e4e67866-dffd-428c-aac7-8d28ddafb39b/mssql-tools_17.7.1.1-1_amd64.apk

# Install the package(s)
RUN apk add --allow-untrusted msodbcsql17_17.7.2.1-1_amd64.apk
RUN apk add --allow-untrusted mssql-tools_17.7.1.1-1_amd64.apk

RUN set -xe \
    && apk add --no-cache --virtual .persistent-deps \
        freetds \
        unixodbc \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        unixodbc-dev \
        freetds-dev \
    && docker-php-source extract \
    && docker-php-ext-install pdo_dblib \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && pecl install \
        sqlsrv \
        pdo_sqlsrv \
    && docker-php-ext-enable --ini-name 30-sqlsrv.ini sqlsrv \
    && docker-php-ext-enable --ini-name 35-pdo_sqlsrv.ini pdo_sqlsrv \
    && docker-php-source delete \
    && apk del .build-deps

# RUN sed -i '/bullseye-updates/d' /etc/apt/sources.list

#RUN apk add shadow && usermod -u 1000 www-data && groupmod -g 1000 www-data
RUN docker-php-ext-install pdo_mysql && \
    docker-php-ext-enable pdo_mysql

RUN docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install opcache

#COPY . .

# Override with custom opcache settings
# COPY config/opcache.ini $PHP_INI_DIR/conf.d/

# RUN pecl install xdebug xhprof && docker-php-ext-enable xdebug xhprof;

EXPOSE 9000