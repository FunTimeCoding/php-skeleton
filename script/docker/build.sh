#!/bin/sh -e

DIRECTORY=$(dirname "${0}")
SCRIPT_DIRECTORY=$(
    cd "${DIRECTORY}" || exit 1
    pwd
)
# shellcheck source=/dev/null
. "${SCRIPT_DIRECTORY}/../../configuration/project.sh"

CONTINUOUS_INTEGRATION_MODE=false

if [ "${1}" = --ci-mode ]; then
    CONTINUOUS_INTEGRATION_MODE=true
fi

script/shell/create-build-information.sh
docker build --tag "${PROJECT_NAME_DASH}-snapshot" .
GIT_TAG=$(git describe --exact-match --tags HEAD 2>/dev/null || echo '')

# TODO: Extract build logs
docker rm "${PROJECT_NAME_DASH}-instance" || true
docker create --name "${PROJECT_NAME_DASH}-instance" \
    "${PROJECT_NAME_DASH}-snapshot"
LOG_PATH="/usr/src/php-skeleton/build/log"
mkdir -p build/log
docker cp "${PROJECT_NAME_DASH}-instance:${LOG_PATH}/junit.xml" \
    build/log/junit.xml
docker rm "${PROJECT_NAME_DASH}-instance"

if [ ! "${GIT_TAG}" = '' ]; then
    if [ "${CONTINUOUS_INTEGRATION_MODE}" = 'true' ]; then
        # Log in on Jenkins. GitLab does that via .gitlab-ci.yml.
        if [ ! "${JENKINS_HOME}" = '' ]; then
            script/docker/login.sh
        fi
    fi

    script/docker/publish.sh "${GIT_TAG}"
    script/kubernetes/deploy.sh "${GIT_TAG}"
fi

# Save space on CI.
if [ "${CONTINUOUS_INTEGRATION_MODE}" = 'true' ]; then
    docker rmi "${PROJECT_NAME_DASH}-snapshot"
    docker image prune --force
fi
