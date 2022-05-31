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
GIT_TAG="${1}"

if [ "${GIT_TAG}" = '' ]; then
    echo "Usage: ${0} GIT_TAG"

    exit 1
fi

LOCATOR="${REGISTRY_SERVER}/${VENDOR_NAME_LOWER}/${PROJECT_NAME_DASH}"

docker tag "${PROJECT_IMAGE_SNAPSHOT}" "${LOCATOR}:${GIT_TAG}"
docker tag "${PROJECT_IMAGE_SNAPSHOT}" "${LOCATOR}:latest"

docker push "${LOCATOR}:${GIT_TAG}"
docker push "${LOCATOR}:latest"

# Clean up local tags
docker rmi "${LOCATOR}:${GIT_TAG}"
docker rmi "${LOCATOR}:latest"
