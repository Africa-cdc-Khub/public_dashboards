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
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd mysqli \
    && docker-php-ext-enable pdo_mysql mbstring exif pcntl bcmath gd mysqli

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable Apache mod_rewrite for Laravel
RUN a2enmod rewrite

# Update Apache to use the correct DocumentRoot
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/tools.africacdc.org/tools/public_dashboards|' /etc/apache2/sites-available/000-default.conf

# Update the Directory block to allow access to the new DocumentRoot
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/c\<Directory /var/www/tools.africacdc.org/tools/public_dashboards>\n    Options Indexes FollowSymLinks\n    AllowOverride All\n    Require all granted\n</Directory>' /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/tools.africacdc.org/tools/public_dashboards

# Expose port 8080
EXPOSE 8080
