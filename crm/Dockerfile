FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
  git \
  unzip \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  libmcrypt-dev \
  libzip-dev \
  zip \
  libpq-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo pdo_mysql gd zip \
  && docker-php-ext-install pdo_pgsql pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html/crm

WORKDIR /var/www/html/crm

RUN composer install

RUN chown -R www-data:www-data /var/www/html/arbitrage-shark/crm/web/runtime /var/www/html/arbitrage-shark/crm/web/assets

EXPOSE 9000

CMD ["php-fpm"]
