FROM php:8.2-apache

# Enable mysqli extension
RUN docker-php-ext-install mysqli

# Copy all files to Apache root
COPY . /var/www/html/

WORKDIR /var/www/html/

# Expose default HTTP port
EXPOSE 10000

# Configure Apache to listen on Render's PORT at runtime
CMD bash -c "echo Listen \$PORT >> /etc/apache2/ports.conf && apache2-foreground"
