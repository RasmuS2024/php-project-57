FROM php:8.2.28-alpine

RUN apk add --no-cache \
    postgresql-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    curl \
    bash

RUN docker-php-ext-install pdo_pgsql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN mkdir -p /app
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-autoloader --no-scripts --no-dev

COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts

COPY . .

RUN composer dump-autoload --optimize && \
    npm run build

COPY ./app/scripts/docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]