FROM php:8.3-fpm

# Build arguments
ARG UID=1000
ARG GID=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    zip \
    sudo \
    && docker-php-ext-install pdo pdo_pgsql zip opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Configure OPcache
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=20000" >> /usr/local/etc/php/conf.d/opcache.ini

# Create user with same UID/GID as host
RUN groupadd -g ${GID} appuser && \
    useradd -u ${UID} -g appuser -m -s /bin/bash appuser && \
    echo 'appuser ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --no-scripts

# Copy application code
COPY . .

# Copy PHP-FPM config and PHP settings
COPY docker/app/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/app/php.ini /usr/local/etc/php/conf.d/custom.ini

# Optimize Composer autoloader
RUN composer dump-autoload --optimize

# Create directories and set permissions
RUN mkdir -p storage/framework/{cache,sessions,views} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R appuser:appuser storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database

# Set proper ownership for the entire application
RUN chown -R appuser:appuser /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 storage bootstrap/cache database

# Switch to non-root user
USER appuser

EXPOSE 9000

CMD ["php-fpm", "-F"]
