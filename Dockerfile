FROM php:8.2.28-fpm 
# Changed to FPM for production-ready setup

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    nodejs \
    npm \ # npm might be included with nodejs via nodesource, but sometimes explicit
    nginx \ # Install Nginx
    curl \
    git \ # Often useful for composer or other needs
    && rm -rf /var/lib/apt/lists/* # Clean up apt cache to reduce image size

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Install Node.js (using NodeSource's script for Node.js 22.x)
# Note: nodejs and npm were already installed via apt-get, this ensures specific version if preferred
RUN curl -sL https://deb.nodesource.com/setup_22.x | bash -
RUN apt-get install -y nodejs

WORKDIR /var/www/html # Standard web server root

# Copy Composer files for caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader # Install production dependencies

# Copy NPM files for caching
COPY package.json package-lock.json ./
RUN npm ci

# Copy the rest of the application files
COPY . .

# Build frontend assets
RUN npm run build

# Configure Nginx
COPY docker/nginx.conf /etc/nginx/sites-available/default # Custom Nginx config
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default \
    && rm -rf /etc/nginx/sites-enabled/default.bak # Ensure default config is linked

# Set appropriate permissions
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type f -exec chmod 664 {} \; \
    && find /var/www/html -type d -exec chmod 775 {} \; \
    && chmod -R 777 /var/www/html/storage # Or restrict permissions more tightly

EXPOSE 80 
# Expose standard HTTP port

# Start PHP-FPM and Nginx
# Migrations should ideally be run as a separate step during deployment.
# For simplicity in CMD if you must:
CMD ["bash", "-c", "php-fpm && nginx -g 'daemon off;'"]
# OR, with a custom entrypoint script:
# COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
# RUN chmod +x /usr/local/bin/entrypoint.sh
# ENTRYPOINT ["entrypoint.sh"]
# CMD ["php-fpm", "nginx"] # entrypoint.sh would handle starting both

# Example docker/entrypoint.sh
#!/bin/bash
# php artisan migrate --force # Run migrations before starting services
# exec "$@" # Execute CMD