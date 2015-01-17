#!/bin/sh -e

CAMEL=${1}

if [ "${CAMEL}" = "" ]; then
    echo "Usage: ${0} MyUpperCamelCaseProjectName"
    exit 1
fi

if [[ ! ${CAMEL} =~ ^([A-Z][a-z0-9]+){2,}$ ]]; then
    echo "Project name must be in UpperCamelCase."
    exit 1
fi

DASH=$(echo ${CAMEL} | sed -E 's/([A-Za-z0-9])([A-Z])/\1-\2/g' | tr '[:upper:]' '[:lower:]')
UNDERSCORE=$(echo ${DASH} | sed -E 's/-/_/g')
INITIALS=$(echo ${CAMEL} | sed 's/\([A-Z]\)[a-z]*/\1/g' | tr '[:upper:]' '[:lower:]' )

echo "Camel: ${CAMEL}"
echo "Dash: ${DASH}"
echo "Initials: ${INITIALS}"

sed -i "" -e "s/\$ec/\$${INITIALS}/g" bin/example-script web/index.php test/ExampleNamespace/ExampleClassTest.php
sed -i "" -e "s/ExampleClass/${CAMEL}/g" bin/example-script web/index.php src/ExampleNamespace/ExampleClass.php test/ExampleNamespace/ExampleClassTest.php
sed -i "" -e "s/ExampleNamespace/${CAMEL}/g" bin/example-script web/index.php src/ExampleNamespace/ExampleClass.php test/ExampleNamespace/ExampleClassTest.php
sed -i "" -e "s/php-skeleton/${DASH}/g" composer.json
sed -i "" -e "s/example-project/${DASH}/g" composer.json

git mv "src/ExampleNamespace" "src/${CAMEL}"
git mv "test/ExampleNamespace" "test/${CAMEL}"

git mv "src/${CAMEL}/ExampleClass.php" "src/${CAMEL}/${CAMEL}.php"
git mv "test/${CAMEL}/ExampleClassTest.php" "src/${CAMEL}/${CAMEL}Test.php"

git mv "bin/example-script" "bin/${INITIALS}"

echo "Done. Files were edited and moved using git. Review those changes. You may also delete this script now."
