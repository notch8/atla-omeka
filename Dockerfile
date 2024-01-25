FROM php:8.2.15-apache as web

RUN a2enmod rewrite
RUN a2enmod headers

ENV DEBIAN_FRONTEND noninteractive
RUN apt-get -qq update && apt-get -qq -y --no-install-recommends install \
    curl \
    imagemagick \
    libfreetype6-dev \
    libjpeg-dev \
    libjpeg62-turbo-dev \
    libmagickcore-dev \
    libmagickwand-dev \
    libmemcached-dev \
    libpng-dev \
    unzip \
    zip \
    zlib1g-dev \
    && echo 'DONE'

# install the PHP extensions we need
RUN pecl install imagick && \
    docker-php-ext-install -j$(nproc) \
      iconv \
      pdo \
      pdo_mysql \
      mysqli \
      gd \
      exif \
    && \
    docker-php-ext-enable exif imagick

COPY . /var/www/html/exhibitions
COPY ./imagemagick-policy.xml /etc/ImageMagick/policy.xml

# Set the ownership of directories to www-data
RUN chown -R www-data:www-data /var/www/html/exhibitions

CMD ["apache2-foreground"]
