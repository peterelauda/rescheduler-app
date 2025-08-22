# Gunakan image PHP + Apache
FROM php:8.3-apache

# Install ekstensi PHP
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip curl git libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip xml mbstring

# Aktifkan mod_rewrite
RUN a2enmod rewrite

# Ubah DocumentRoot Apache ke /var/www/html/public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update konfigurasi virtualhost bawaan Apache
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Salin Composer dari image resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project ke container (dari host)
COPY . /var/www/html

# Ubah owner agar Apache bisa akses
RUN chown -R www-data:www-data /var/www/html