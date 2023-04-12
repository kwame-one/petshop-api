FROM php:8.2-fpm-alpine

# Copy composer.lock and composer.json
COPY src/composer.lock src/composer.json /var/www/petshop_api/

# Set working directory
WORKDIR /var/www/petshop_api

# Install Additional dependencies
RUN apk update && apk add --no-cache \
    build-base shadow vim curl \
    php \
    php-fpm \
    php-common \
    php-pdo \
    php-pdo_mysql \
    php-mysqli \
    php-mbstring \
    php-xml \
    php-openssl \
    php-json \
    php-phar \
    php-zip \
    php-gd \
    php-dom \
    php-session \
    php-zlib


# Add and Enable PHP-PDO Extenstions
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-enable pdo_mysql

# Install PHP Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Remove Cache
RUN rm -rf /var/cache/apk/*

# Add UID '1000' to www-data
RUN usermod -u 1000 www-data

# Copy existing application directory permissions
COPY --chown=www-data:www-data src/ /var/www/petshop_api

# Change current user to www
USER www-data

RUN composer install

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
