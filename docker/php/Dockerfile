ARG PHP_VERSION="8.0"
FROM php:${PHP_VERSION}-cli

RUN printf 'tzdata tzdata/Areas select Europe\ntzdata tzdata/Zones/Europe select Zurich\n' | debconf-set-selections; \
    rm /etc/timezone /etc/localtime; \
    dpkg-reconfigure -f noninteractive tzdata

# Use the default development PHP configuration
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY docker/php/*.sh /usr/local/bin/

RUN . /usr/local/bin/install-utilities.sh
RUN . /usr/local/bin/install-php-zip-extension.sh
RUN . /usr/local/bin/install-php-xdebug-extension.sh
RUN . /usr/local/bin/install-composer.sh

#ARG COMPOSER_AUTH
#RUN echo "${COMPOSER_AUTH}" > ~/.composer/auth.json

WORKDIR /app

ENTRYPOINT [ "composer" ]
