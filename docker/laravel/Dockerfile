FROM php:8.3-fpm-alpine3.19

# Install dependencies
RUN apk --no-cache add \
        libzip-dev \
        unzip \
        curl \
        postgresql-dev \
        icu-dev \
        gettext-dev && \
    rm -rf /var/cache/apk/* && \
    mkdir -p /app

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql bcmath intl gettext zip exif

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Default command to start FPM
ENTRYPOINT ["sh", "-c", "composer install && php-fpm"]
