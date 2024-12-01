# Menggunakan base image resmi PHP 8.2 dengan FPM
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nodejs \
    npm \
    supervisor \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Salin file Laravel ke container
COPY . .

# Salin file .env
COPY .env .env

# Install dependensi Laravel
RUN composer install --no-dev --optimize-autoloader

# Set permission untuk storage dan bootstrap
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Expose port untuk Nginx
EXPOSE 9000

# Jalankan PHP-FPM
CMD ["php-fpm"]
