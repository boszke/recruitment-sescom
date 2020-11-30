#FROM php:7.4-cli
#FROM composer:2.0

#RUN apt-get update

#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#COPY . /var/www/recruitment-sescom
#WORKDIR /var/www/recruitment-sescom

FROM php:7.4-cli
FROM composer:2.0
COPY . /var/www/recruitment-sescom
WORKDIR /var/www/recruitment-sescom
ENTRYPOINT /bin/bash