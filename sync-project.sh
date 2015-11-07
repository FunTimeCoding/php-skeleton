#!/bin/sh -e

usage()
{
    echo "Usage: ${0} TARGET_PROJECT"
}

if [ "${1}" = "" ]; then
    usage

    exit 1
fi

TARGET_PROJECT="${1}"

if [ ! -d "${TARGET_PROJECT}" ]; then
    echo "Target directory does not exist."

    exit 1
fi

cp README.md "${TARGET_PROJECT}"
cp LICENSE "${TARGET_PROJECT}"
cp *.sh "${TARGET_PROJECT}"
cp sonar-project.properties "${TARGET_PROJECT}"
cp composer.json "${TARGET_PROJECT}"
cp phpunit.xml "${TARGET_PROJECT}"
cp .php_cs "${TARGET_PROJECT}"
cp .phpmd.xml "${TARGET_PROJECT}"
cp .phpunit.ci.xml "${TARGET_PROJECT}"
rm "${TARGET_PROJECT}/init-project.sh"
rm "${TARGET_PROJECT}/sync-project.sh"
echo "Done. Files were copied to ${TARGET_PROJECT}. Review those changes."
