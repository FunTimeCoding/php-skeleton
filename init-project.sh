#!/bin/sh -e
# This tool can be used to initialise the template after making a fresh copy to get started quickly.
# The goal is to make it as easy as possible to create scripts that allow easy testing and continuous integration.

CAMEL=$(echo "${1}" | grep -E '^([A-Z][a-z0-9]+){2,}$') || CAMEL=""

if [ "${CAMEL}" = "" ]; then
    echo "Usage: ${0} MyUpperCamelCaseProjectName"

    exit 1
fi

OS=$(uname)

if [ "${OS}" = "Darwin" ]; then
    SED="gsed"
else
    SED="sed"
fi

DASH=$(echo "${CAMEL}" | ${SED} -E 's/([A-Za-z0-9])([A-Z])/\1-\2/g' | tr '[:upper:]' '[:lower:]')
INITIALS=$(echo "${CAMEL}" | ${SED} 's/\([A-Z]\)[a-z]*/\1/g' | tr '[:upper:]' '[:lower:]' )
echo "CAMEL: ${CAMEL}"
echo "DASH: ${DASH}"
echo "INITIALS: ${INITIALS}"
find -E . -type f ! -regex '^.*/(build|vendor|\.git|\.idea)/.*$' -exec sh -c '${1} -i -e "s/PhpSkeleton/${2}/g" ${3}' '_' "${SED}" "${CAMEL}" '{}' \;
find -E . -type f ! -regex '^.*/(build|vendor|\.git|\.idea)/.*$' -exec sh -c '${1} -i -e "s/php-skeleton/${2}/g" ${3}' '_' "${SED}" "${DASH}" '{}' \;
git mv src/PhpSkeleton.php "src/${CAMEL}.php"
git mv test/Unit/PhpSkeletonTest.php "test/Unit/${CAMEL}Test.php"
git mv bin/ps "bin/${INITIALS}"
composer dump-autoload
rm init-project.sh
echo "Done. Files were edited and moved using git. Review those changes."
