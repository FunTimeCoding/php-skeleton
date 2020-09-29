FROM php:7.3-cli
MAINTAINER Alexander Reitzel
WORKDIR /usr/src
COPY src php-skeleton/src
COPY vendor php-skeleton/vendor
COPY bin php-skeleton/bin
WORKDIR /usr/src/php-skeleton
CMD ["bin/phsk"]
