# Use the official PHP image as the base image
FROM php:8.3-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    && docker-php-ext-install curl

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy the rest of the application code
COPY . /var/www/html/

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install the dependencies with verbose output and scripts enabled
RUN composer install --ignore-platform-reqs -vvv

# Copy the .env.example to .env
RUN cp /var/www/html/.env.example /var/www/html/.env

# Generate the autoloader
RUN composer dump-autoload

# Generate Laravel application key
RUN php artisan key:generate

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Configure Apache for redirection
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Enable mod_rewrite
RUN a2enmod rewrite

# Expose port 80 for Apache
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
