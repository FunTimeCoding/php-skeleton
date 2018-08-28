#!/bin/sh -e

# Development mode mounts the project root so it can be edited and re-ran without rebuilding the image and recreating the container.

if [ "${1}" = --development ]; then
    DEVELOPMENT=true
else
    DEVELOPMENT=false
fi

docker ps --all | grep --quiet php-skeleton && FOUND=true || FOUND=false

if [ "${FOUND}" = false ]; then
    if [ "${DEVELOPMENT}" = true ]; then
        docker create --name php-skeleton --volume $(pwd):/php-skeleton funtimecoding/php-skeleton
    else
        docker create --name php-skeleton funtimecoding/php-skeleton
    fi

    # TODO: Specifying the entry point overrides CMD in Dockerfile. Is this useful, or should all sub commands go through one entry point script? I'm inclined to say one entry point script per project.
    #docker create --name php-skeleton --volume $(pwd):/php-skeleton --entrypoint /php-skeleton/bin/other.sh funtimecoding/php-skeleton
    #docker create --name php-skeleton funtimecoding/php-skeleton /php-skeleton/bin/other.sh
    # TODO: Run tests this way?
    #docker create --name php-skeleton funtimecoding/php-skeleton /php-skeleton/script/docker/test.sh
fi

docker start --attach php-skeleton
