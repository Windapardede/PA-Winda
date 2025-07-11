FROM php:8.2-cli

# Install ekstensi yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libreoffice \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip gd

# Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy seluruh project ke dalam container
COPY . /var/www

# Install dependencies Laravel
RUN composer install

# Expose port 8000
EXPOSE 8000

# Atur batas upload file dan post size
RUN echo "upload_max_filesize=100M\npost_max_size=100M" > /usr/local/etc/php/conf.d/uploads.ini

# Jalankan Laravel development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
