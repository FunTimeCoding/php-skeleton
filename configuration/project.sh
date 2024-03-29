#!/bin/sh -e

SYSTEM=$(uname)

if [ "${SYSTEM}" = Darwin ]; then
    SED='gsed'
else
    SED='sed'
fi

VENDOR_NAME_CAMEL='FunTimeCoding'
export VENDOR_NAME_CAMEL

PROJECT_NAME_CAMEL='PhpSkeleton'
export PROJECT_NAME_CAMEL

PROJECT_NAME_DASH='php-skeleton'
export PROJECT_NAME_DASH

PROJECT_NAME_UNDERSCORE=$(echo "${PROJECT_NAME_DASH}" | ${SED} --regexp-extended 's/-/_/g')
export PROJECT_NAME_UNDERSCORE

PROJECT_NAME_INITIALS=$(echo "${PROJECT_NAME_CAMEL}" | ${SED} 's/\([A-Z]\)[a-z]*/\1/g' | tr '[:upper:]' '[:lower:]')
BLOCKED_INITIALS='ps
pu
fg'

echo "${PROJECT_NAME_INITIALS}" | grep --quiet "^${BLOCKED_INITIALS}$" && ARE_INITIALS_BLOCKED=true || ARE_INITIALS_BLOCKED=false

if [ "${ARE_INITIALS_BLOCKED}" = true ]; then
    PROJECT_NAME_INITIALS=$(echo "${PROJECT_NAME_CAMEL}" | ${SED} 's/\([A-Z][a-z]\)[a-z]*/\1/g' | tr '[:upper:]' '[:lower:]')
fi

export PROJECT_NAME_INITIALS

PROJECT_VERSION='0.1.0'
export PROJECT_VERSION

PACKAGE_VERSION='1'
export PACKAGE_VERSION

MAINTAINER='Alexander Reitzel'
export MAINTAINER

EMAIL='funtimecoding@gmail.com'
export EMAIL

COMBINED_VERSION="${PROJECT_VERSION}-${PACKAGE_VERSION}"
export COMBINED_VERSION

VENDOR_NAME_LOWER=$(echo "${VENDOR_NAME_CAMEL}" | tr '[:upper:]' '[:lower:]')
export VENDOR_NAME_LOWER

# build, tmp, .git, .idea, .scannerwork, .tox, .cache, __pycache__, *.egg-info: Nothing will ever have to be replaced by this.
# vendor: Do not not break php-skeleton based projects when synchronizing with them.
# node_modules: Do not not break java-script-skeleton based projects.
# target: Do not not break java-skeleton based projects.
# shellcheck disable=SC1117
EXCLUDE_FILTER='^.*\/(build|tmp|vendor|node_modules|target|\.git|\.vagrant|\.idea|\.scannerwork|\.tox|\.cache|__pycache__|[a-z_]+\.egg-info)\/.*$'
export EXCLUDE_FILTER

# lib: shell, ruby
# src: php, java, clojure, scala, c-sharp
# test: php
# benchmark: php
# tests: python
# spec: ruby
# PROJECT_NAME_UNDERSCORE: python
# TODO: Test and expand this through all skeleton projects.
# shellcheck disable=SC1117
INCLUDE_FILTER="^\.\/((src|test|benchmark|tests|spec|lib|debian|configuration|documentation|test|script\/skeleton|helm-chart|${PROJECT_NAME_UNDERSCORE})\/.*|\.gitignore|Vagrantfile|Dockerfile|README.md|package\.json|sonar-project\.properties|web\/index\.html|composer\.json|setup\.py|pom.xml|.*\.gemspec|.*\.cabal|docker-compose.yml)$"
export INCLUDE_FILTER
INCLUDE_STILL_FILTER='^.*\/__pycache__\/.*$'
export INCLUDE_STILL_FILTER
EXCLUDE_DOCUMENTATION_FILTER='^\.\/(documentation\/dictionary)\/.*$'
export EXCLUDE_DOCUMENTATION_FILTER

PROJECT_IMAGE_DEVELOPMENT="${PROJECT_NAME_DASH}-development"
export PROJECT_IMAGE_DEVELOPMENT
PROJECT_IMAGE_SNAPSHOT="${PROJECT_NAME_DASH}-snapshot"
export PROJECT_IMAGE_SNAPSHOT

PROJECT_CONTAINER_DEVELOPMENT="${PROJECT_NAME_DASH}-instance"
export PROJECT_CONTAINER_DEVELOPMENT

git config --get remote.origin.url | grep --quiet github.com && IS_GITHUB=true || IS_GITHUB=false
export IS_GITHUB

if [ "${IS_GITHUB}" = 'true' ]; then
    REGISTRY_SERVER='ghcr.io'
else
    REGISTRY_SERVER="${PRIVATE_REGISTRY_SERVER}"
fi

export REGISTRY_SERVER
