FROM php:8.2-cli

RUN set -e; \
    apt-get update \
    && apt-get --no-install-recommends install -y libpq-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && curl --proto "=https" --tlsv1.2 -sSf -L https://deb.nodesource.com/setup_22.14.0 | bash \
    && apt-get --no-install-recommends install -y nodejs \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-dev\
    && npm ci --ignore-scripts\
    && npm run build

COPY /app/scripts/docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
CMD ["/usr/local/bin/docker-entrypoint.sh"]