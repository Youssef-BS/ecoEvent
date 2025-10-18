FROM php:8.2-fpm

# Install 15+ system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    zip unzip libzip-dev default-mysql-client \
    npm nodejs supervisor cron

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application
COPY . .
RUN chown -R www-data:www-data /var/www

# Install dependencies
USER www-data
RUN composer install --no-dev --optimize-autoloader
RUN npm ci --only=production && npm run build

# Set permissions
USER root
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
