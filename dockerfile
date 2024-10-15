FROM php:8.2.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && docker-php-ext-enable pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite for Laravel
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/tools.africacdc.org/tools/public_dashboards

# Set the Apache document root to the correct directory
RUN sed -i 's|/var/www/html|/var/www/tools.africacdc.org/tools/public_dashboards|g' /etc/apache2/sites-available/000-default.conf

# Expose port 8080
EXPOSE 8080
