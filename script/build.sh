#!/bin/sh -e

if [ "${1}" = --ci-mode ]; then
    script/docker/build.sh --ci-mode
else
    # TODO: Run check, measure and test inside a Docker CI target. Do not pollute the production image.
    sh -ex script/php/build.sh
fi
