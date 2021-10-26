#!/bin/sh -e

# TODO: This rather needs the Dockerfile to include Composer, because the project may have PHP dependencies not available in the stock Composer image.
mkdir -p tmp/composer-cache
# shellcheck disable=SC2046
winpty docker run --rm --interactive --tty \
    --volume /$(pwd):/app \
    --volume "${COMPOSER_HOME:-$HOME/.composer}:/tmp" \
    composer install

# TODO: Consider --environment TMPDIR=/tmp/composer to not have to mount over /tmp
