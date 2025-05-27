# Dockerfile
FROM php:8.3-cli

# Install dependensi
RUN apt-get update && apt-get install -y \
  git \
  curl \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  unzip \
  libicu-dev \
  zlib1g-dev \
  libzip-dev

# Install ekstensi PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js dan npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
  apt-get install -y nodejs

# Set working directory
WORKDIR /app

# Copy file project
COPY . .

# Install dependensi Laravel
RUN composer install

# Install dependensi npm
RUN npm install

# Expose port
EXPOSE 8000

# Jalankan Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
