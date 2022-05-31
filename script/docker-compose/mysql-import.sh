#!/bin/sh -e

docker cp schema.sql php-skeleton_mysql_1:/tmp/schema.sql
docker-compose exec mysql sh -c 'mysql --user=root --password=root php_skeleton </tmp/schema.sql'
