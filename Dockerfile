# Use official PHP image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Copy the project files to container
COPY . /var/www/html/

# Enable Apache mod_rewrite (needed for URL routing)
RUN a2enmod rewrite

# Install mysqli extension for MySQL connections
RUN docker-php-ext-install mysqli

# Set environment variables (optional defaults)
ENV DB_HOST=localhost \
    DB_NAME=wedding_planner \
    DB_USER=root \
    DB_PASS= \
    DB_PORT=3306

# Expose default port for Apache
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
