
FROM php:8.2-fpm

# Increase PHP-FPM process limits to handle more concurrent requests
RUN { \
    echo "pm = dynamic"; \
    echo "pm.max_children = 20"; \
    echo "pm.start_servers = 5"; \
    echo "pm.min_spare_servers = 3"; \
    echo "pm.max_spare_servers = 10"; \
} >> /usr/local/etc/php-fpm.d/www.conf

# Install system dependencies and PHP extensions
RUN apt-get update \
    && apt-get install -y libpng-dev libonig-dev libxml2-dev libzip-dev zip unzip git curl libicu-dev \
    && docker-php-ext-install pdo_mysql mbstring bcmath gd intl zip

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Copy composer from official composer image
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Set permissions
RUN chown -R www-data:www-data /var/www
