FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    build-essential \
    git \
    curl \
    mc \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libgd-dev \
    jpegoptim optipng pngquant gifsicle \
    libonig-dev \
    libxml2-dev \
    zip \
    sudo \
    unzip \
    nano \
    tree \
    fish \
# imagik
    libmagickwand-dev --no-install-recommends && \
    pecl install imagick && \
    docker-php-ext-enable imagick
# end imagik


RUN apt-get update && apt-get install -y \
    && pecl install redis \
    && docker-php-ext-enable redis

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
# Install PHP extensions
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY ./_docker/app/php.ini /usr/local/etc/php/php.ini
COPY ./_docker/entrypoint.sh /var/www/entrypoint.sh
COPY ./laravel /var/www
COPY ./.env /var/www/_docker/

RUN chmod 777 -R storage
RUN chmod +x /var/www/entrypoint.sh

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

#ENTRYPOINT ["/var/www/entrypoint.sh"]

