# Menggunakan image PHP dengan FPM dan Composer
FROM php:8.2-fpm

# Mengatur direktori kerja
WORKDIR /var/www/html

# Instal ekstensi PHP yang dibutuhkan
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin semua file ke container
COPY . .

# Set izin file untuk direktori Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Menjalankan perintah Composer
RUN composer install --no-dev --optimize-autoloader

# Expose port untuk Laravel
EXPOSE 8000

# Perintah untuk menjalankan aplikasi
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
