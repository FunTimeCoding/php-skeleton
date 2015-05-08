#!/bin/sh -e

if [ "${1}" = "--ci-mode" ]; then
    shift
    mkdir -p build/log
    vendor/bin/phpunit -c phpunit.ci.xml
else
    vendor/bin/phpunit "$@"
fi
