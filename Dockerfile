FROM php:8.1-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY ./p_prod-jp /var/www/html
