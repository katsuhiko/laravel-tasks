FROM nginx:1.14-alpine

COPY ./docker/server/nginx/default.conf /etc/nginx/conf.d/

RUN mkdir -p /var/www/html/public
COPY ./public/ /var/www/html/public
