#!/bin/sh -e

DIRECTORY=$(dirname "${0}")
SCRIPT_DIRECTORY=$(
    cd "${DIRECTORY}" || exit 1
    pwd
)
# shellcheck source=/dev/null
. "${SCRIPT_DIRECTORY}/../../configuration/project.sh"
# shellcheck source=/dev/null
. "${HOME}/.static-analysis-tools.sh"

CONTINUOUS_INTEGRATION_MODE=false

if [ "${1}" = --ci-mode ]; then
    CONTINUOUS_INTEGRATION_MODE=true
fi

script/shell/build-information.sh
docker build --target development --tag "${PROJECT_IMAGE_DEVELOPMENT}" .
# TODO: Make the instance run OS independent like in composer.sh and development.sh
docker run --rm --interactive --tty \
    --volume "${COMPOSER_HOME:-${HOME}/.composer}:/tmp" \
    --volume "$(pwd)/build:/usr/src/php-skeleton/build" \
    --volume "${HOME}/.static-analysis-tools.sh:/root/.static-analysis-tools.sh" \
    --env SONAR_LOCATOR="${SONAR_LOCATOR}" \
    --env SONAR_TOKEN="${SONAR_TOKEN}" \
    "${PROJECT_IMAGE_DEVELOPMENT}" script/build.sh
GIT_TAG=$(git describe --exact-match --tags HEAD 2>/dev/null || echo '')

if [ ! "${GIT_TAG}" = '' ]; then
    docker build --target production --tag "${PROJECT_IMAGE_SNAPSHOT}" .

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
    docker rmi "${PROJECT_IMAGE_DEVELOPMENT}"
    docker rmi "${PROJECT_IMAGE_SNAPSHOT}"
    docker image prune --force
fi
