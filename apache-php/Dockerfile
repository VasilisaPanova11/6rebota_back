FROM php:8.0-apache
WORKDIR /var/www/
RUN apt-get update && apt-get install -y libaprutil1-dbd-mysql \
	libzip-dev \
	libpng-dev \
	libjpeg-dev \
	libfreetype6-dev \
	git \
	zip \
	unzip \
	&& docker-php-ext-configure gd --with-freetype \
	&& docker-php-ext-install mysqli gd \
	&& a2enmod authn_dbd  

RUN pecl install redis && docker-php-ext-enable redis
RUN chown -R www-data:www-data /var/www/html/

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY composer.json .

RUN composer install

EXPOSE 80