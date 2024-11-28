#!/bin/bash

# Codes ANSI
RED='\033[0;31m'  # Rouge
GREEN='\033[0;32m' # Vert
NC='\033[0m'      # Blanc

# Affichage du pourcentage
show_percentage() {
    local progress=0
    while [ "$progress" -le 100 ]; do
        printf "\rMise en place de l'environnement Docker : %d%%" "$progress"
        sleep 0.1
        progress=$((progress + 1))
    done
    echo
}

# Vérifier si Docker est lancé
if ! docker info > /dev/null 2>&1; then
    echo -e "${RED}>> Docker n'est pas lancé. Veuillez démarrer Docker et réessayer.${NC}"
    exit 1
fi

# Mise en place de l'environnement sans sortie dans la console
{
    docker stop pma db web > /dev/null 2>&1
    docker rm pma db web > /dev/null 2>&1
    docker volume rm web-educational_app_dbdata > /dev/null 2>&1
    docker image rm matap:edu.1.0 > /dev/null 2>&1
    docker build -t matap:edu.1.0 . > /dev/null 2>&1
    docker compose up -d > /dev/null 2>&1
} &

# Afficher la progression pendant les opérations
show_percentage

localhost="http://localhost:8080"

echo -e "${GREEN}Profitez de l'application dans votre navigateur à l'adresse : \033[4m${localhost}\033[0m"
