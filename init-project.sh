#!/bin/sh -e
# This tool is to initialize the project after cloning.
# The goal is to make easy to create and test new projects.

CAMEL=$(echo "${1}" | grep -E '^([A-Z]+[a-z0-9]*){2,}$') || CAMEL=""

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
${FIND} . -type f -regextype posix-extended ! -regex '^.*/(build|vendor|\.git|\.idea)/.*$' -exec sh -c '${1} -i -e "s/PhpSkeleton/${2}/g" -e "s/php-skeleton/${3}/g" -e "s/bin\/ps/bin\/${4}/g" "${5}"' '_' "${SED}" "${CAMEL}" "${DASH}" "${INITIALS}" '{}' \;
git mv src/PhpSkeleton.php src/"${CAMEL}".php
git mv test/Unit/PhpSkeletonTest.php test/Unit/"${CAMEL}"Test.php
git mv bin/ps bin/"${INITIALS}"
# TODO: What if composer.phar is not downloaded yet?
#./composer.phar dump-autoload
echo "Done. Files were edited and moved. Review those changes."
