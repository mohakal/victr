FROM php:apache

# Copy your application code into the container
COPY . /var/www/html

# Install mysqli extension and restart Apache service
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli && apachectl restart

# Start Apache service
CMD ["apache2-foreground"]