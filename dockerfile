FROM php:8.4-fpm

#Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libyaml-dev \
    && rm -rf /var/lib/apt/lists/*

#Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo pdo_mysql \
    && pecl install yaml \
    && docker-php-ext-enable yaml

#Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#Set working directory
WORKDIR /var/www/html

# Configure git to treat this directory as safe
RUN git config --global --add safe.directory /var/www/html

# Copy only composer files to leverage Docker cache
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

# Copy the rest of the application code
COPY . .
