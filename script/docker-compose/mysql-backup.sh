#!/bin/sh -e

docker-compose exec mysql mysqldump --user=root --password=root --databases php_skeleton >tmp/php_skeleton.sql
