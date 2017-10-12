#!/bin/sh -e

CAMEL=$(echo "${1}" | grep --extended-regexp '^([A-Z]+[a-z0-9]*){2,}$') || CAMEL=""

if [ "${CAMEL}" = "" ]; then
    echo "Usage: ${0} UpperCamelCaseName"

    exit 1
fi

SYSTEM=$(uname)

if [ "${SYSTEM}" = Darwin ]; then
    SED=gsed
    FIND=gfind
else
    SED=sed
    FIND=find
fi

DASH=$(echo "${CAMEL}" | ${SED} -E 's/([A-Za-z0-9])([A-Z])/\1-\2/g' | tr '[:upper:]' '[:lower:]')
INITIALS=$(echo "${CAMEL}" | ${SED} 's/\([A-Z]\)[a-z]*/\1/g' | tr '[:upper:]' '[:lower:]')
rm init-project.sh sync-project.sh
# shellcheck disable=SC2016
${FIND} . -type f -regextype posix-extended ! -regex '^.*/(build|vendor|\.git|\.idea)/.*$' -exec sh -c '${1} --in-place --expression "s/PhpSkeleton/${2}/g" --expression "s/php-skeleton/${3}/g" --expression "s/bin\/ps/bin\/${4}/g" "${5}"' '_' "${SED}" "${CAMEL}" "${DASH}" "${INITIALS}" '{}' \;
git mv src/PhpSkeleton.php "src/${CAMEL}.php"
git mv test/Unit/PhpSkeletonTest.php "test/Unit/${CAMEL}Test.php"
git mv bin/ps "bin/${INITIALS}"
composer dump-autoload
echo "Done. Files were edited and moved. Review those changes."
