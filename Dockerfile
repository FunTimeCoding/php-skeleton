FROM php:7.4-cli AS base
MAINTAINER Alexander Reitzel
COPY --from=mlocati/php-extension-installer:1.5.11 /usr/bin/install-php-extensions /usr/local/bin
RUN install-php-extensions xml mbstring
RUN mkdir /usr/src/php-skeleton
WORKDIR /usr/src/php-skeleton
COPY bin bin
COPY src src
COPY web web
COPY vendor vendor
COPY composer.json composer.json
COPY composer.lock composer.lock

FROM base AS development
COPY --from=composer:2.3.5 /usr/bin/composer /usr/local/bin/composer
RUN install-php-extensions zip xdebug ast
RUN apt-get --quiet 2 update
RUN apt-get --quiet 2 install unzip shellcheck python3 git hunspell
RUN mv /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini
COPY configuration/docker/xdebug.txt /usr/local/etc/php/conf.d/xdebug.ini
COPY script script
COPY configuration configuration
COPY documentation documentation
COPY test test
COPY .git .git
COPY .phan .phan
COPY .php_cs.php .php_cs.php
COPY .phpstan.neon .phpstan.neon
COPY .phpmd.xml .phpmd.xml
COPY .phpunit.ci.xml .phpunit.ci.xml
COPY phpunit.xml phpunit.xml
COPY infection.json.dist infection.json.dist
COPY psalm.xml psalm.xml
COPY depfile.yml depfile.yml

FROM base AS production
RUN mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
CMD ["bin/phsk"]
