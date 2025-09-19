FROM php:8.2-apache

# Set working directory first
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip git unzip curl libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql bcmath zip

# Install Node.js for Vite
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy composer.json & composer.lock for caching
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy frontend files and install npm dependencies
COPY package*.json vite.config.js ./
RUN npm install && npm run build

# Copy the rest of the backend code
COPY . .

# Expose Laravel port
EXPOSE 8000

# Run migrations and start Laravel
CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"]
