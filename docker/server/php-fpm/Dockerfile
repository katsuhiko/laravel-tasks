FROM katsuhikonagashima/php-fpm-mysql:7.2-stretch

COPY ./ /var/www/html

RUN php composer.phar install
RUN cp .env.example .env
RUN php artisan key:generate

RUN chmod -R 777 /var/www/html/storage \
        /var/www/html/bootstrap/cache
