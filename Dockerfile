# Gunakan PHP dengan Apache
FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git && \
    docker-php-ext-install pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin source code
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Beri izin writable pada storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Jalankan perintah yang dibutuhkan (migrate, optimize, dll)
RUN composer install --no-dev --optimize-autoloader

# Expose port
EXPOSE 8080
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]

# Set Apache document root ke public folder
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Aktifkan Apache mod_rewrite
RUN a2enmod rewrite
