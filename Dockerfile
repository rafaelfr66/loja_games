FROM php:8.5-apache

RUN docker-php-ext-install pdo_mysql

RUN echo 'RedirectMatch 404 "/\.(env|git)"' > /etc/apache2/conf-enabled/bloquear-arquivos.conf
