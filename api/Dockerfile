FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    wget \
    curl \
    nano \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer (latest version 2.8.5)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/api

# Copy project files into the container
COPY . .

# Install PHP dependencies
RUN composer install

# Copy custom Apache config (ensure this file is in the same directory as your Dockerfile)
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Set correct permissions
RUN chown -R www-data:www-data /var/www/api

EXPOSE 80
