FROM php:8.2-fpm

#COPY . /var/www/html/arbitrage-shark/redirect-service
COPY . /public/*

WORKDIR /var/www/html/arbitrage-shark/redirect-service

RUN chown -R www-data:www-data /var/www/html/arbitrage-shark/redirect-service

EXPOSE 9000

CMD ["php-fpm"]
