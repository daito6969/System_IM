FROM php:8.2-apache

# Install and enable PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy all project files to Apache root
COPY . /var/www/html/

# Set working directory and permissions
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html

# Expose HTTP port
EXPOSE 80

CMD ["apache2-foreground"]
