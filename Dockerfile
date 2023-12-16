FROM php:8.2-cli
VOLUME [ "/var/www/html"]
WORKDIR "/var/www/html"
RUN apt-get update && apt-get install -y zip git unzip
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN echo 'xdebug.mode=develop,debug,coverage' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.client_host=host.debug.internal' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.start_with_request=yes' >> /usr/local/etc/php/php.ini
RUN echo 'session.save_path = "/tmp"' >> /usr/local/etc/php/php.ini

# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# configure limits
RUN echo 'memory_limit=-1' > /usr/local/etc/php/conf.d/memory_limit.ini