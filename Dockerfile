FROM php:8.2-apache

# Enable mysqli
RUN docker-php-ext-install mysqli

# Copy your files
COPY . /var/www/html/

WORKDIR /var/www/html/

# Use Render's assigned port
ENV PORT=10000
EXPOSE $PORT

# Tell Apache to listen on Render's port
RUN echo "Listen ${PORT}" >> /etc/apache2/ports.conf

CMD ["apache2-foreground"]
