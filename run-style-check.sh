#!/bin/sh -e

if [ "$(command -v shellcheck || true)" = "" ]; then
    echo "Command not found: shellcheck"

    exit 1
fi

CONTINUOUS_INTEGRATION_MODE=false
FIX_STYLE=false

if [ "${1}" = "--ci-mode" ]; then
    shift
    mkdir -p build/log
    CONTINUOUS_INTEGRATION_MODE=true
fi

if [ "${1}" = "--fix" ]; then
    shift
    FIX_STYLE=true
fi

#     12345678901234567890123456789012345678901234567890123456789012345678901234567890
echo "================================================================================"
echo
echo "Run Mess Detector. Documentation: http://phpmd.org/documentation/index.html"
RETURN_CODE="0"

if [ "${CONTINUOUS_INTEGRATION_MODE}" = true ]; then
    vendor/bin/phpmd src,test xml .phpmd.xml --reportfile build/log/pmd-pmd.xml || RETURN_CODE="${?}"
else
    vendor/bin/phpmd src,test text .phpmd.xml || RETURN_CODE="${?}"
fi

echo

if [ "${RETURN_CODE}" = "2" ]; then
    echo "Violations detected."
elif [ "${RETURN_CODE}" = "1" ]; then
    echo "An error occurred."
else
    echo "No mess detected."
fi

echo
echo "================================================================================"
echo
echo "Run Code Sniffer."
RETURN_CODE="0"

if [ "${CONTINUOUS_INTEGRATION_MODE}" = true ]; then
    vendor/bin/phpcs --report=checkstyle --report-file=build/log/checkstyle-result.xml --standard=PSR2 src test || RETURN_CODE="${?}"
else
    vendor/bin/phpcs --standard=PSR2 src test || RETURN_CODE="${?}"
fi

if [ "${RETURN_CODE}" = "0" ]; then
    echo "No smells detected."
else
    echo "Code smells detected."
fi

echo
echo "================================================================================"
echo

if [ "${CONTINUOUS_INTEGRATION_MODE}" = true ]; then
    vendor/bin/phpcpd --log-pmd build/log/pmd-cpd.xml src test
else
    vendor/bin/phpcpd src test
fi

echo
echo "================================================================================"

if [ "${CONTINUOUS_INTEGRATION_MODE}" = true ]; then
    echo
    mkdir -p build/pdepend
    vendor/bin/pdepend --jdepend-xml=build/log/jdepend.xml --summary-xml=build/log/jdepend-summary.xml --jdepend-chart=build/pdepend/dependencies.svg --overview-pyramid=build/pdepend/pyramid.svg src,test
    echo
    echo "================================================================================"
fi

echo
echo "Run ShellCheck."

if [ "${CONTINUOUS_INTEGRATION_MODE}" = true ]; then
    # shellcheck disable=SC2016
    find . -name '*.sh' -and -not -path '*/vendor/*' -exec sh -c 'shellcheck ${1} || true' '_' '{}' \; | tee build/log/shellcheck.txt
else
    # shellcheck disable=SC2016
    find . -name '*.sh' -and -not -path '*/vendor/*' -exec sh -c 'shellcheck ${1} || true' '_' '{}' \;
fi

echo
echo "================================================================================"
echo
echo "Dry-run PHP-CS-Fixer."

if [ "${CONTINUOUS_INTEGRATION_MODE}" = true ]; then
    FOUND_CONCERNS=false
    vendor/bin/php-cs-fixer fix . --dry-run --config-file .phpcs.php | tee build/log/php-cs-fixer.txt || FOUND_CONCERNS=true
else
    FOUND_CONCERNS=false
    vendor/bin/php-cs-fixer fix . --dry-run --config-file .phpcs.php || FOUND_CONCERNS=true

    if [ "${FOUND_CONCERNS}" = true ]; then
        if [ "${FIX_STYLE}" = true ]; then
            echo "Now really run PHP-CS-Fixer."
            vendor/bin/php-cs-fixer fix . --config-file .phpcs.php || true
        fi
    fi
fi

echo
echo "================================================================================"
