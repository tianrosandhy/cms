FROM php:8.0-apache

# Handle Apache sites config
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install dependencies
RUN apt update && apt install -y git zlib1g-dev libzip-dev libjpeg62-turbo-dev libpng-dev libwebp-dev && rm -rf /var/lib/apt/lists/*

# Install PHP Extensions
RUN docker-php-ext-configure gd --with-jpeg --with-webp
RUN docker-php-ext-install mysqli pdo pdo_mysql gd zip exif
RUN a2enmod headers http2 rewrite ssl proxy_fcgi
COPY php/php.ini "$PHP_INI_DIR/php.ini"

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
