FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
  build-essential \
  libpng-dev \
  libjpeg-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  unzip \
  curl \
  libzip-dev \
  git \
  && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js (latest LTS)
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
  && apt-get install -y nodejs \
  && npm install -g npm

WORKDIR /var/www/html
