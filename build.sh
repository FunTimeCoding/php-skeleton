#!/bin/sh -e

rm -rf build
composer install --no-interaction --no-progress
./style-check.sh --ci-mode
./tests.sh --ci-mode
./metrics.sh --ci-mode
