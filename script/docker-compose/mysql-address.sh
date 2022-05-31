#!/bin/sh -e

docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' php-skeleton_mysql_1
