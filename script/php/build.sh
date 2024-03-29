#!/bin/sh -e

if [ -f /.dockerenv ]; then
    export COMPOSER_ALLOW_SUPERUSER=1
else
    script/clean.sh
fi

if [ -f composer.phar ]; then
    php composer.phar install --no-interaction --no-progress
else
    composer install --no-interaction --no-progress --no-scripts
fi

script/check.sh --ci-mode
# Run test before measure so that SonarQube can read the PHPUnit coverage.
script/test.sh --ci-mode
script/measure.sh --ci-mode
#SYSTEM=$(uname)
#
# TODO: Needs polish.
#if [ "${SYSTEM}" = Linux ]; then
#    script/debian/package.sh
#    script/docker/build.sh
#fi
