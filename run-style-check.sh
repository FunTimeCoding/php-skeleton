#!/bin/sh -e

CI_MODE=0

if [ "${1}" = "--ci-mode" ]; then
    shift
    mkdir -p build/log
    CI_MODE=1
fi

#     12345678901234567890123456789012345678901234567890123456789012345678901234567890
echo "================================================================================"
echo ""
echo "Run Mess Detector. Documentation: http://phpmd.org/documentation/index.html"
CODE="0"

if [ "${CI_MODE}" = "1" ]; then
    vendor/bin/phpmd src,test xml .phpmd.xml --reportfile build/log/pmd-pmd.xml || CODE="${?}"
else
    vendor/bin/phpmd src,test text .phpmd.xml || CODE="${?}"
fi

if [ "${CODE}" = "2" ]; then
    echo "Violations occurred."
elif [ "${CODE}" = "1" ]; then
    echo "An error occured."
else
    echo "No mess detected."
fi

echo ""
echo "================================================================================"
echo ""
echo "Run Code Sniffer."

if [ "${CI_MODE}" = "1" ]; then
    vendor/bin/phpcs --report=checkstyle --report-file=build/log/checkstyle-result.xml --standard=PSR2 src test
else
    vendor/bin/phpcs --standard=PSR2 src test
fi

echo ""
echo "================================================================================"
echo ""

if [ "${CI_MODE}" = "1" ]; then
    vendor/bin/phpcpd --log-pmd build/log/pmd-cpd.xml src test
else
    vendor/bin/phpcpd src test
fi

echo ""
echo "================================================================================"

if [ "${CI_MODE}" = "1" ]; then
    echo ""
    mkdir -p build/pdepend
    vendor/bin/pdepend --jdepend-xml=build/log/jdepend.xml --summary-xml=build/log/jdepend-summary.xml --jdepend-chart=build/pdepend/dependencies.svg --overview-pyramid=build/pdepend/pyramid.svg src,test
    echo ""
    echo "================================================================================"
fi

echo ""

if [ "$(command -v shellcheck || true)" = "" ]; then
    echo "Skip ShellCheck because it is not installed."
else
    echo "Run ShellCheck."
    find . -name '*.sh' -and -not -path '*/vendor/*' -exec sh -c 'shellcheck ${1} || true' '_' '{}' \;
fi

echo ""
echo "================================================================================"
echo ""

echo "Run PHP-CS-Fixer."
if [ "${CI_MODE}" = "1" ]; then
    vendor/bin/php-cs-fixer fix . --dry-run | tee build/log/php-cs-fixer.txt
else
    vendor/bin/php-cs-fixer fix . --dry-run
fi

echo ""
echo "================================================================================"
