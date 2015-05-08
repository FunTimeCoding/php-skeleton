#!/bin/sh -e

if [ "${WORKSPACE}" = "" ]; then
    SCRIPT_DIR=$(cd $(dirname ${0}); pwd)
    WORKSPACE="${SCRIPT_DIR}"
fi

echo "WORKSPACE: ${WORKSPACE}"
COMPOSER_BIN="composer.phar"
COMPOSER_PATH="${WORKSPACE}/${COMPOSER_BIN}"

if [ ! -f "${COMPOSER_PATH}" ]; then
    curl -sS https://getcomposer.org/installer | php -- --install-dir="${WORKSPACE}" --filename="${COMPOSER_BIN}"
fi

"${COMPOSER_PATH}" selfupdate
"${COMPOSER_PATH}" install --no-interaction --no-progress
rm -rf "${WORKSPACE}/build"
"${WORKSPACE}/run-style-check.sh" --ci-mode
"${WORKSPACE}/run-metrics.sh" --ci-mode
"${WORKSPACE}/run-tests.sh" --ci-mode
