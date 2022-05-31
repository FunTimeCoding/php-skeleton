#!/bin/sh -e

DIRECTORY=$(dirname "${0}")
SCRIPT_DIRECTORY=$(
    cd "${DIRECTORY}" || exit 1
    pwd
)
# shellcheck source=/dev/null
. "${SCRIPT_DIRECTORY}/../../configuration/project.sh"
# shellcheck source=/dev/null
. "${HOME}/.virtualization-tools.sh"

if [ "${1}" = --help ]; then
    echo "Usage: ${0} --development|[GIT_TAG]"
    echo "Examples:"
    echo "In development: ${0} --development"
    echo "In production: ${0} 1.0.0"

    exit 0
fi

if [ "${1}" = --development ]; then
    DEVELOPMENT=true
    shift
else
    DEVELOPMENT=false
fi

if [ "${DEVELOPMENT}" = true ]; then
    IMAGE="${PROJECT_IMAGE_SNAPSHOT}"
else
    GIT_TAG="${1}"

    if [ "${GIT_TAG}" = '' ]; then
        GIT_TAG='latest'
        shift
    fi

    IMAGE="${REGISTRY_SERVER}/${VENDOR_NAME_LOWER}/${PROJECT_NAME_DASH}:${GIT_TAG}"
fi

SYSTEM=$(uname -o)

if [ "${SYSTEM}" = 'Msys' ]; then
    # shellcheck disable=SC2068
    winpty docker run --interactive --tty --rm --name "${PROJECT_CONTAINER_DEVELOPMENT}" "${IMAGE}" ${@}
else
    # shellcheck disable=SC2068
    docker run --interactive --tty --rm --name "${PROJECT_CONTAINER_DEVELOPMENT}" "${IMAGE}" ${@}
fi
