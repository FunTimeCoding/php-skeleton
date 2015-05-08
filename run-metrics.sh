#!/bin/sh -e

if [ "${1}" = "--ci-mode" ]; then
    shift
    mkdir -p build/log
    vendor/bin/phploc --count-tests src test | tee build/log/phploc.log
    #vendor/bin/phploc --count-tests src test --log-xml build/log/phploc.xml
    #vendor/bin/phploc --count-tests src test --log-csv build/log/phploc.csv
    sonar-runner | tee build/log/sonar-runner.log
else
    vendor/bin/phploc --count-tests src test
fi
