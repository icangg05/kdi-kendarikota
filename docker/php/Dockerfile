FROM php:8.3-apache

# -----------------------------
# Install dependencies & Node.js
# -----------------------------
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    curl \
    git \
    ca-certificates \
    gnupg \
 && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
 && apt-get install -y nodejs \
 && npm install -g npm@latest \
 && docker-php-ext-configure intl \
 && docker-php-ext-install mysqli pdo_mysql mbstring exif pcntl bcmath gd zip intl

# -----------------------------
# Install Composer
# -----------------------------
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# -----------------------------
# Apache config
# -----------------------------
RUN a2enmod rewrite

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# -----------------------------
# Laravel setup
# -----------------------------
WORKDIR /var/www/html

# Pastikan folder Laravel punya permission yang benar
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
 && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
 && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# -----------------------------
# PHP config (upload size)
# -----------------------------
# Buat file php.ini custom
RUN echo "upload_max_filesize=500M\npost_max_size=500M\nmemory_limit=512M\n" > /usr/local/etc/php/conf.d/uploads.ini

# -----------------------------
# Laravel storage link
# -----------------------------
# (biar gak error kalau artisan belum ada pas build, pakai || true)
RUN php artisan storage:link || true
