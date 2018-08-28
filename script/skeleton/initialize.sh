#!/bin/sh -e

DIRECTORY=$(dirname "${0}")
SCRIPT_DIRECTORY=$(cd "${DIRECTORY}" || exit 1; pwd)
# shellcheck source=/dev/null
. "${SCRIPT_DIRECTORY}/../../lib/common.sh"
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
# shellcheck disable=SC2016
${FIND} . -regextype posix-extended -type f ! -regex "${EXCLUDE_FILTER}" -exec sh -c '${1} --in-place --expression "s/PhpSkeleton/${2}/g" --expression "s/php-skeleton/${3}/g" "${4}"' '_' "${SED}" "${NAME}" "${DASH}" '{}' \;
${SED} --in-place --expression "s/bin\/ps/bin\/${INITIALS}/g" --expression "s/'ps'/'${INITIALS}'/g" README.md Vagrantfile Dockerfile
git mv src/PhpSkeleton.php "src/${NAME}.php"
git mv test/Unit/PhpSkeletonTest.php "test/Unit/${NAME}Test.php"
git mv bin/ps "bin/${INITIALS}"
echo "# This dictionary file is for domain language." > "documentation/dictionary/${DASH}.dic"
composer dump-autoload
