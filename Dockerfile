# Use official PHP image
FROM php:7.4-apache

# Set working directory in the container
WORKDIR /var/www/html

# Install MySQLi extension for PHP
RUN apt-get update && \
    apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev && \
    docker-php-ext-install gd pdo pdo_mysql

# Copy your PHP files into the container
COPY . /var/www/html/

# Expose port 80 (Apache default)
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]