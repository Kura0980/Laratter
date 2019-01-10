FROM php:7.3.0-fpm

# install composer
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer
RUN apt-get update \
&& apt-get install -y \
git \
zip \
unzip \
vim

# install php extention
RUN apt-get update \
    && apt-get install -y \
        libpq-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

# install xdebug
RUN pecl install xdebug-2.7.0beta1 && \
    docker-php-ext-enable xdebug

WORKDIR /var/www