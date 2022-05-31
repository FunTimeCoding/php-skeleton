#!/bin/sh -e

docker-compose exec mysql mysql --user=root --password=root php_skeleton <tmp/php_skeleton.sql
