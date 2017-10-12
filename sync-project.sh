#!/bin/sh -e

TARGET="${1}"

if [ "${TARGET}" = "" ]; then
    echo "Usage: ${0} TARGET"

    exit 1
fi

if [ ! -d "${TARGET}" ]; then
    echo "Target directory ${TARGET} does not exist."

    exit 1
fi

CAMEL=$(head -n1 "${TARGET}/README.md" | awk '{ print $2 }' | grep --extended-regexp '^([A-Z]+[a-z0-9]*){2,}$') || CAMEL=""

if [ "${CAMEL}" = "" ]; then
    echo "Could not determine the projects name in ${TARGET}."

    exit 1
fi

SYSTEM=$(uname)

if [ "${SYSTEM}" = Darwin ]; then
    FIND=gfind
    SED=gsed
else
    FIND=find
    SED=sed
fi

cp ./*.md "${TARGET}"
cp ./*.sh "${TARGET}"
cp dict/*.dic "${TARGET}/dict"
cp doc/*.md "${TARGET}/doc"
cp sonar-project.properties "${TARGET}"
cp composer.json "${TARGET}"
cp phpunit.xml "${TARGET}"
cp .gitignore "${TARGET}"
cp .php_cs.php "${TARGET}"
cp .phpmd.xml "${TARGET}"
cp .phpunit.ci.xml "${TARGET}"
cd "${TARGET}" || exit 1
DASH=$(echo "${CAMEL}" | ${SED} --regexp-extended 's/([A-Za-z0-9])([A-Z])/\1-\2/g' | tr '[:upper:]' '[:lower:]')
INITIALS=$(echo "${CAMEL}" | ${SED} 's/\([A-Z]\)[a-z]*/\1/g' | tr '[:upper:]' '[:lower:]')
rm init-project.sh sync-project.sh
# shellcheck disable=SC2016
${FIND} . -type f -regextype posix-extended ! -regex '^.*/(build|vendor|\.git|\.idea)/.*$' -exec sh -c '${1} --in-place --expression "s/PhpSkeleton/${2}/g" --expression "s/php-skeleton/${3}/g" --expression "s/bin\/ps/bin\/${4}/g" "${5}"' '_' "${SED}" "${CAMEL}" "${DASH}" "${INITIALS}" '{}' \;
echo "Done. Files were copied to ${TARGET} and modified. Review those changes."
