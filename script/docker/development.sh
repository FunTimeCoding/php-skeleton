#!/bin/sh -e

DIRECTORY=$(dirname "${0}")
SCRIPT_DIRECTORY=$(
    cd "${DIRECTORY}" || exit 1
    pwd
)
# shellcheck source=/dev/null
. "${SCRIPT_DIRECTORY}/../../configuration/project.sh"

SYSTEM=$(uname)

if [ "${SYSTEM}" = 'Darwin' ]; then
    docker run --rm --interactive --tty \
        --volume $(pwd):/usr/src/php-skeleton \
        --volume "${COMPOSER_HOME:-${HOME}/.composer}:/tmp" \
        --entrypoint bash \
        "${PROJECT_IMAGE_DEVELOPMENT}"
else
    SYSTEM=$(uname -o)

    if [ "${SYSTEM}" = 'Msys' ]; then
        echo "Not implemented: ${SYSTEM}"
    else
        echo "Not implemented: ${SYSTEM}"
    fi
fi
