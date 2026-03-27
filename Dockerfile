
FROM php:8.2-fpm

# Tune PHP-FPM for the slower filesystem characteristics of a Docker bind mount on Windows.
RUN { \
    echo "[www]"; \
    echo "listen = 9000"; \
    echo "pm = dynamic"; \
    echo "pm.max_children = 40"; \
    echo "pm.start_servers = 8"; \
    echo "pm.min_spare_servers = 4"; \
    echo "pm.max_spare_servers = 12"; \
    echo "pm.max_requests = 500"; \
    echo "request_terminate_timeout = 180s"; \
    echo "pm.process_idle_timeout = 10s"; \
    echo "catch_workers_output = yes"; \
    echo "clear_env = no"; \
} > /usr/local/etc/php-fpm.d/zz-sarab-performance.conf

# Install system dependencies and PHP extensions
RUN apt-get update \
    && apt-get install -y libpng-dev libonig-dev libxml2-dev libzip-dev zip unzip git curl libicu-dev \
    && docker-php-ext-install pdo_mysql mbstring bcmath gd intl zip opcache

RUN { \
    echo "opcache.enable=1"; \
    echo "opcache.enable_cli=1"; \
    echo "opcache.memory_consumption=192"; \
    echo "opcache.interned_strings_buffer=16"; \
    echo "opcache.max_accelerated_files=20000"; \
    echo "opcache.validate_timestamps=1"; \
    echo "opcache.revalidate_freq=0"; \
    echo "realpath_cache_size=4096K"; \
    echo "realpath_cache_ttl=600"; \
} > /usr/local/etc/php/conf.d/zz-sarab-opcache.ini

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Copy composer from official composer image
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer


# Set permissions
RUN chown -R www-data:www-data /var/www

# Ensure the storage symlink exists, but don't fail restarts if it's already present.
ENTRYPOINT ["sh", "-c", "php artisan storage:link || true; exec php-fpm -F"]
