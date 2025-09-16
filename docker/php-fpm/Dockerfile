FROM php:8.4-fpm-alpine
WORKDIR /var/www/html
# Install PHP extensions and dependencies
RUN apk  add \
    build-base \
    freetype-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    bash \
    fcgi \
    libmcrypt-dev \
    oniguruma-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev 
    
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    linux-headers && \
    apk del .build-deps

RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath  


COPY --chown=www-data:www-data . /var/www/html


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install

COPY . .

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache


EXPOSE 9000

CMD ["php-fpm"]