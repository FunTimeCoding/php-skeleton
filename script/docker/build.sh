#!/bin/sh -e

docker images | grep --quiet funtimecoding/php-skeleton && FOUND=true || FOUND=false

if [ "${FOUND}" = true ]; then
    docker rmi funtimecoding/php-skeleton
fi

docker build --tag funtimecoding/php-skeleton .
