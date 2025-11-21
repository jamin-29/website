# Use official PHP image with Apache
FROM php:8.2-apache

# Copy PHP project into container
COPY . /var/www/html/

# Enable Apache mod_rewrite (useful for frameworks)
RUN a2enmod rewrite

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html

# Install mysqli or pdo_mysql (if needed)
RUN docker-php-ext-install mysqli pdo pdo_mysql

EXPOSE 80