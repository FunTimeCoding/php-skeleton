#!/bin/sh -e

DIRECTORY=$(dirname "${0}")
SCRIPT_DIRECTORY=$(
    cd "${DIRECTORY}" || exit 1
    pwd
)
# shellcheck source=/dev/null
. "${SCRIPT_DIRECTORY}/../../configuration/project.sh"
NAME=$(echo "${1}" | grep --extended-regexp '^([A-Z]+[a-z0-9]*){1,}$') || NAME=''

if [ "${NAME}" = '' ]; then
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
DASH=$(echo "${NAME}" | ${SED} --regexp-extended 's/([A-Za-z0-9])([A-Z])/\1-\2/g' | tr '[:upper:]' '[:lower:]')
INITIALS=$(echo "${NAME}" | ${SED} 's/\([A-Z]\)[a-z]*/\1/g' | tr '[:upper:]' '[:lower:]')
UNDERSCORE=$(echo "${DASH}" | ${SED} --regexp-extended 's/-/_/g')
# shellcheck disable=SC2016
${FIND} . -regextype posix-extended -type f -regex "${INCLUDE_FILTER}" ! -regex "${EXCLUDE_DOCUMENTATION_FILTER}" -exec sh -c '${1} --in-place --expression "s/PhpSkeleton/${2}/g" --expression "s/php-skeleton/${3}/g" --expression "s/php_skeleton/${4}/g" "${5}"' '_' "${SED}" "${NAME}" "${DASH}" "${UNDERSCORE}" '{}' \;
# shellcheck disable=SC1117
${SED} --in-place --expression "s/phsk/${INITIALS}/g" README.md Dockerfile
git mv src/PhpSkeleton.php "src/${NAME}.php"
git mv test/Unit/PhpSkeletonTest.php "test/Unit/${NAME}Test.php"
git mv bin/phsk "bin/${INITIALS}"

if [ -f composer.phar ]; then
    php composer.phar dump-autoload
else
    composer dump-autoload
fi
