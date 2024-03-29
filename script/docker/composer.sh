#!/bin/sh -e

DIRECTORY=$(dirname "${0}")
SCRIPT_DIRECTORY=$(
    cd "${DIRECTORY}" || exit 1
    pwd
)
# shellcheck source=/dev/null
. "${SCRIPT_DIRECTORY}/../../configuration/project.sh"

mkdir -p tmp/composer-cache
SYSTEM=$(uname)

# TODO: Pass --environment TMPDIR=/tmp/composer to not mount ~/.composer over /tmp
if [ "${SYSTEM}" = 'Darwin' ]; then
    docker run --rm --interactive --tty \
        --volume $(pwd):/usr/src/php-skeleton \
        --volume "${COMPOSER_HOME:-${HOME}/.composer}:/tmp" \
        "${PROJECT_IMAGE_DEVELOPMENT}" composer ${@}
else
    SYSTEM=$(uname -o)

    if [ "${SYSTEM}" = 'Msys' ]; then
        # shellcheck disable=SC2046
        winpty docker run --rm --interactive --tty \
            --volume /$(pwd):/app \
            --volume "${COMPOSER_HOME:-${HOME}/.composer}:/tmp" \
            "${PROJECT_IMAGE_DEVELOPMENT}" composer ${@}
    else
        echo "Not implemented: ${SYSTEM}"
    fi
fi
