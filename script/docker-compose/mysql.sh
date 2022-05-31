#!/bin/sh -e

if [ "${1}" = '--tcp' ]; then
    mysql --user=root --password=root --host localhost --port 3307 --protocol TCP php_skeleton
else
    docker-compose exec mysql mysql --user=root --password=root php_skeleton
fi
