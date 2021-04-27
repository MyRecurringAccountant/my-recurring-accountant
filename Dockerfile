FROM php:8-apache

# Install xdebug, Redis and PDO
RUN \
  pecl install xdebug-3.0.4 && \
  docker-php-ext-enable xdebug
RUN \
  docker-php-ext-install pdo pdo_mysql
RUN \
  pecl install redis-5.3.4 && \
  docker-php-ext-enable redis

# Configure PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY php-conf/* $PHP_INI_DIR/conf.d/

# Install program
COPY src/ /var/www/html/
EXPOSE 80
