FROM php:8.1-fpm

#RUN rm /etc/apt/sources.list
#
#RUN echo "deb [trusted=yes] http://archive.debian.org/debian-security jessie/updates main" >> /etc/apt/sources.list.d/jessie.list
#
#RUN echo "deb [trusted=yes] http://archive.debian.org/debian jessie main" >> /etc/apt/sources.list.d/jessie.list

RUN apt-get update -y && apt-get install -y libpng-dev zlib1g-dev libzip-dev zip libfreetype6-dev libwebp-dev libjpeg62-turbo-dev libgmp-dev libldb-dev libldap2-dev netcat sqlite3 libsqlite3-dev libpq-dev && \
    ln -s /usr/lib/x86_64-linux-gnu/libldap.so /usr/lib/libldap.so \
    && ln -s /usr/lib/x86_64-linux-gnu/liblber.so /usr/lib/liblber.so \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install mysqli pdo pdo_mysql pdo_sqlite gd zip gmp bcmath pcntl ldap sysvmsg exif \
    && docker-php-ext-configure pgsql --with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql  && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

# Install supervisor
RUN apt-get install -y supervisor

# Set working directory
WORKDIR /var/www

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
# PHP Error Log Files
RUN mkdir -p /home/logs/supervisor-logs

# add root to www group
RUN chown -R www:www-data /home/logs/ && chmod -R ug+w /home/logs/supervisor-logs

# Change current user to www
USER www

# Copy code to /var/www
COPY dockerfiles/php/run.sh /var/run.sh

# Expose port 9000 and start php-fpm server
EXPOSE 9000

ENTRYPOINT ["/var/run.sh"]
