# 🏫 Créer une application web pour l'inscription des enseignants aux journées pédagogiques
![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white) ![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white) ![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
## Objectif
- Développer une application web fonctionnelle.
- Afficher les ateliers proposés pour la journée pédagogique avec le nombre de places disponibles.
- Si l'atelier est complet, permettre aux utilisateurs de rejoindre la liste d'attente.
- Visualiser l'emplacement, la date et l'heure de l'atelier.
- Option de se désinscrire d'un atelier.

### En tant qu'administrateur du site :
- Gérer les événements (créer, supprimer, modifier).
- Modifier les participants (exclure, ajouter).

## Technologies utilisées
Les technologies suivantes seront utilisées dans ce projet :
- Docker
- HTML5
- CSS3
- PHP
- SQL

## Installation
- Avoir [Docker](https://docs.docker.com/engine/install/) de lancé sur son poste.
- Télécharger le repo `git clone https://github.com/mateja-velickovic/web-educational_app.git`.
- Se rendre dans le répertoire `cd web-educational_app`.
- Ajouter votre clé API dans `\p_prod-jp\src\php\authentication\config.ini.php`.
- Initaliser le projet `sh init.sh`.
- Profiter de l'application dans votre navigateur à l’adresse `localhost:8080`.

### Si besoin
Ajouter votre adresse mail dans la liste des utilisateurs admin dans `\p_prod-jp\src\php\authentication\login.php:23`.
