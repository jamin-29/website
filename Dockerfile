# Use official PHP with Apache
FROM php:8.2-apache

WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html/

# Enable Apache rewrite module
RUN a2enmod rewrite

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Expose port 10000 (Render passes $PORT automatically)
EXPOSE 10000

# Start Apache
CMD ["apache2-foreground"]
