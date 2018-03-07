#!/bin/sh -e

NAME=$(echo "${1}" | grep --extended-regexp '^([A-Z]+[a-z0-9]*){2,}$') || NAME=""

if [ "${NAME}" = "" ]; then
    echo "Usage: ${0} NAME"
    echo "Name must be in upper camel case."

    exit 1
fi

SYSTEM=$(uname)

if [ "${SYSTEM}" = Darwin ]; then
    SED='gsed'
    FIND='gfind'
else
    SED='sed'
    FIND='find'
fi

rm -rf script/skeleton
DASH=$(echo "${NAME}" | ${SED} -E 's/([A-Za-z0-9])([A-Z])/\1-\2/g' | tr '[:upper:]' '[:lower:]')
INITIALS=$(echo "${NAME}" | ${SED} 's/\([A-Z]\)[a-z]*/\1/g' | tr '[:upper:]' '[:lower:]')
# shellcheck disable=SC2016
${FIND} . -type f -regextype posix-extended ! -regex '^.*/(build|vendor|\.git|\.idea)/.*$' -exec sh -c '${1} --in-place --expression "s/PhpSkeleton/${2}/g" --expression "s/php-skeleton/${3}/g" --expression "s/bin\/ps/bin\/${4}/g" "${5}"' '_' "${SED}" "${NAME}" "${DASH}" "${INITIALS}" '{}' \;
git mv src/PhpSkeleton.php "src/${NAME}.php"
git mv test/Unit/PhpSkeletonTest.php "test/Unit/${NAME}Test.php"
git mv bin/ps "bin/${INITIALS}"
composer dump-autoload
