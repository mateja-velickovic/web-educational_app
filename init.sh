#!/bin/bash

if ! docker info > /dev/null 2>&1; then
    echo "Docker n'est pas lancé. Veuillez démarrer Docker et réessayer."
    exit 1
fi

docker stop pma db web && docker rm pma db web && \
docker volume rm web-educational_app_dbdata
docker image rm matap:edu.1.0
docker build -t matap:edu.1.0 .
docker compose up -d
