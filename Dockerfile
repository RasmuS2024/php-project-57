FROM php:8.2.28-cli

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    # Добавляем очистку кеша для уменьшения размера образа
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo pdo_pgsql zip

# Безопасная установка Composer (официальным методом)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка Node.js через официальный репозиторий (без pipe bash)
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /app

# Копируем только необходимые для установки зависимостей файлы
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --optimize-autoloader

COPY package.json package-lock.json ./
RUN npm ci

# Копируем остальные файлы
COPY . .

# Завершаем установку
RUN composer dump-autoload --optimize \
    && npm run build

# Разрешаем запись в storage (для Laravel)
RUN chmod -R 775 storage bootstrap/cache

# Используем отдельный скрипт для запуска
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]