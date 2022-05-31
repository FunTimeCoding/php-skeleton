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

cat >helm-chart/Chart.yaml <<EOF
apiVersion: v2
name: ${PROJECT_NAME_DASH}
description: ${PROJECT_NAME_DASH} microservice
type: application

appVersion: ${GIT_TAG}
version: ${GIT_TAG}.1
EOF

docker run --rm --volume "${PWD}/helm-chart:/helm-chart" --volume "${HOME}/.kube:/root/.kube" dtzar/helm-kubectl helm list --short | grep --quiet "${PROJECT_NAME_DASH}" && IS_INSTALLED=true || IS_INSTALLED=false

if [ "${IS_INSTALLED}" = 'true' ]; then
    HELM_COMMAND='upgrade'
else
    HELM_COMMAND='install'
fi

docker run --rm --volume "${PWD}/helm-chart:/helm-chart" --volume "${HOME}/.kube:/root/.kube" dtzar/helm-kubectl helm "${HELM_COMMAND}" --set "ImagePrefix=${REGISTRY_SERVER}/${VENDOR_NAME_LOWER}" "${PROJECT_NAME_DASH}" /helm-chart
git checkout helm-chart/Chart.yaml
