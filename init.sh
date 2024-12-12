#!/bin/bash

# Codes ANSI
RED='\033[0;31m'  # Rouge
GREEN='\033[0;32m' # Vert
NC='\033[0m'      # Blanc

# Vérifier si Docker est lancé
if ! docker info > /dev/null 2>&1; then
    echo -e "${RED}>> Docker n'est pas lancé. Veuillez démarrer Docker et réessayer.${NC}"
    exit 1
fi

echo -e "${NC}Mise en place de l'environnement..."

docker stop pma db web > /dev/null 2>&1
docker rm pma db web > /dev/null 2>&1
docker volume rm web-educational_app_dbdata > /dev/null 2>&1
docker image rm matap:edu.1.0 > /dev/null 2>&1
docker build -t matap:edu.1.0 . > /dev/null 2>&1
docker compose up -d > /dev/null 2>&1

localhost="http://localhost:8080"

echo -e "${GREEN}Profitez de l'application dans votre navigateur à l'adresse : \033[4m${localhost}\033[0m"
