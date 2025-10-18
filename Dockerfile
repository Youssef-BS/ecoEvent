# Stage 1: Frontend build
FROM node:20-alpine as frontend

WORKDIR /app

COPY package*.json ./
COPY vite.config.js ./
COPY resources/ ./resources/

RUN npm install && npm run build

# Stage 2: PHP application
FROM php:8.2-fpm

WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    zip unzip libzip-dev default-mysql-client \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application
COPY . .

# Copy built assets from frontend stage
COPY --from=frontend /app/public/build /var/www/public/build

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 storage bootstrap/cache

# Install PHP dependencies (no dev)
USER www-data
RUN composer install --no-dev --optimize-autoloader

USER root

EXPOSE 9000
CMD ["php-fpm"]