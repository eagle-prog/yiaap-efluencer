FROM php:5.6-apache

RUN apt-get update -yqq\
    && apt-get install -y libcurl4-openssl-dev ffmpeg  libpng-dev libjpeg-dev zlib1g-dev exim4  &&\
     echo 'sendmail_path = "/usr/sbin/exim4 -t"' >> /usr/local/etc/php/conf.d/mail.ini && \
     echo 'SMTP = localhost' >> /usr/local/etc/php/conf.d/mail.ini && \
     echo 'smtp_port = 25' >> /usr/local/etc/php/conf.d/mail.ini

COPY exim4.conf /etc/exim4/exim4.conf
RUN chmod 644 /etc/exim4/exim4.conf

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN docker-php-ext-install mysqli
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip
RUN docker-php-ext-install curl
RUN docker-php-ext-configure gd --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd

RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/ssl-cert-snakeoil.key -out /etc/ssl/certs/ssl-cert-snakeoil.pem -subj "/C=AT/ST=Vienna/L=Vienna/O=Security/OU=Development/CN=mega.local"

###########################################################################
# xDebug:
###########################################################################

USER root


RUN   pecl install xdebug-2.5.5; \
  docker-php-ext-enable xdebug

# ADD for REMOTE debugging
COPY xdebug.ini /etc/php/5.6/cli/conf.d/xdebug.ini
# Copy xdebug configuration for remote debugging
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN sed -i "s/xdebug.remote_autostart=0/xdebug.remote_autostart=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
    sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
    sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" /usr/local/etc/php/conf.d/xdebug.ini

#check if we really need imagemagick
#ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
#RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
#    install-php-extensions imagick

RUN a2enmod proxy_wstunnel
RUN a2enmod rewrite
RUN a2ensite default-ssl
RUN a2enmod ssl
RUN a2enmod deflate

RUN ln -s /usr/bin/ffmpeg /usr/local/bin/ffmpeg








