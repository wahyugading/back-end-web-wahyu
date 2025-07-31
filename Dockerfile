# Gunakan image PHP resmi dengan Apache
FROM php:8.2-apache

# Install ekstensi dan alat yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git unzip zip curl libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Salin seluruh project Laravel ke direktori Apache
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Aktifkan mod_rewrite (Laravel butuh ini)
RUN a2enmod rewrite

# Ubah Apache agar root-nya ke public/
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Ubah permission untuk Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install dependencies Laravel
RUN composer install --no-dev --optimize-autoloader

# Jangan jalankan artisan saat build! Tunggu sampai live
# RUN php artisan config:clear
# RUN php artisan cache:clear
# RUN php artisan config:cache

# Laravel akan dijalankan oleh Apache
CMD ["apache2-foreground"]