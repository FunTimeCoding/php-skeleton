#!/bin/sh -e

TARGET="${1}"

if [ "${TARGET}" = "" ]; then
    echo "Usage: ${0} TARGET"

    exit 1
fi

if [ ! -d "${TARGET}" ]; then
    echo "Target directory does not exist."

    exit 1
fi

NAME=$(head -n1 "${TARGET}/README.md" | awk '{ print $2 }' | grep --extended-regexp '^([A-Z]+[a-z0-9]*){2,}$') || NAME=""

if [ "${NAME}" = "" ]; then
    echo "Could not determine the project name."

    exit 1
fi

SYSTEM=$(uname)

if [ "${SYSTEM}" = Darwin ]; then
    FIND='gfind'
    SED='gsed'
else
    FIND='find'
    SED='sed'
fi

cp ./*.md "${TARGET}"
mkdir -p "${TARGET}/documentation"
cp -R documentation/* "${TARGET}/documentation"
mkdir -p "${TARGET}/script"
cp -R script/* "${TARGET}/script"
cp sonar-project.properties "${TARGET}"
cp composer.json "${TARGET}"
cp phpunit.xml "${TARGET}"
cp .gitignore "${TARGET}"
cp .php_cs.php "${TARGET}"
cp .phpmd.xml "${TARGET}"
cp .phpunit.ci.xml "${TARGET}"
cd "${TARGET}" || exit 1
rm -rf script/skeleton
DASH=$(echo "${NAME}" | ${SED} --regexp-extended 's/([A-Za-z0-9])([A-Z])/\1-\2/g' | tr '[:upper:]' '[:lower:]')
INITIALS=$(echo "${NAME}" | ${SED} 's/\([A-Z]\)[a-z]*/\1/g' | tr '[:upper:]' '[:lower:]')
# shellcheck disable=SC2016
${FIND} . -type f -regextype posix-extended ! -regex '^.*/(build|vendor|\.git|\.idea)/.*$' -exec sh -c '${1} --in-place --expression "s/PhpSkeleton/${2}/g" --expression "s/php-skeleton/${3}/g" --expression "s/bin\/ps/bin\/${4}/g" "${5}"' '_' "${SED}" "${NAME}" "${DASH}" "${INITIALS}" '{}' \;
