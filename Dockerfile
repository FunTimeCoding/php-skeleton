FROM php:7.3-cli
MAINTAINER Alexander Reitzel
WORKDIR /usr/src
COPY src php-skeleton/src
#COPY vendor php-skeleton/vendor
COPY bin php-skeleton/bin
COPY configuration php-skeleton/configuration
COPY script php-skeleton/script
COPY composer.json php-skeleton/composer.json
COPY composer.lock php-skeleton/composer.lock
WORKDIR /usr/src/php-skeleton
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY --from=mlocati/php-extension-installer:latest /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions zip xdebug xml mbstring ast
RUN apt-get --quiet 2 update
RUN apt-get --quiet 2 install unzip
RUN script/build.sh
CMD ["bin/phsk"]
