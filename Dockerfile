FROM php:7.2-apache

RUN apt-get update; apt-get install -y git zip unzip vim nano gnupg2
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get update -y \
  && apt-get install -y libxml2-dev nodejs zip unzip zlib1g-dev libpng-dev libjpeg-dev \
  && apt-get clean -y \
  && docker-php-ext-install soap pdo pdo_mysql intl gd zip bcmath opcache intl
RUN a2enmod rewrite
RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime
COPY ./docker/php/php.ini /usr/local/etc/php/
COPY ./docker/apache/default.conf /etc/apache2/sites-available/000-default.conf
RUN pecl install redis && docker-php-ext-enable redis

EXPOSE 80

COPY . /var/www/html/
WORKDIR /var/www/html
RUN composer install
RUN npm install
RUN php bin/console assets:install
RUN rm -rf /var/www/html/var/cache/*; chmod -R 777 /var/www/html/var
EXPOSE 8001
CMD ["sh", "-c","make migrate;apache2-foreground"]