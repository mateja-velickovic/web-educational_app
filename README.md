# 🏫 Créer une application web pour l'inscription des enseignants aux journées pédagogiques
![Docker](https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white) ![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white) ![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white) ![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)

## 🔐 Connectez-vous à l'application via le portail EduVaud
![Image de la page d'accueil en étant déconnecté](https://github.com/user-attachments/assets/62809335-1879-44f7-85d7-20d43549b9b6)

## 🏔 Organisez vous en rejoingant les activités auxquelles vous souhaitez participer
![Image de la page d'accueil en étant connecté et en pouvant voir les activités](https://github.com/user-attachments/assets/ad8da3f2-45fd-43c8-9265-636193e09372)

## ⏱ Consultez le récapitulatif de votre journée avec le planning
![Image du récapitulatif des activités que l'utilisateur a rejoint](https://github.com/user-attachments/assets/6ef87b08-8d88-42a8-bfd1-aa0666f6f54b)

## ✏ Administrez facilement et rapidement les différentes activités (privilège requis)
![Image de la page pour editer et supprimer des activités](https://github.com/user-attachments/assets/9a18860d-b7f7-49ea-9f21-55e733eb2d98)

## 🧠 Innovez et proposez de nouvelles activités (privilège requis)
![Image qui représente la création d'une nouvelle activité](https://github.com/user-attachments/assets/9f6fae4a-6600-42d8-a2dc-e915314d7ab3)


## ❔ Objectif de l'application
- Développer une application web fonctionnelle.
- Afficher les ateliers proposés pour la journée pédagogique avec le nombre de places disponibles.
- Si l'atelier est complet, permettre aux utilisateurs de rejoindre la liste d'attente.
- Visualiser l'emplacement, la date et l'heure de l'atelier.
- Option de se désinscrire d'un atelier.

### 🛠 En tant qu'administrateur du site :
- Gérer les événements (créer, supprimer, modifier).
- Modifier les participants (exclure, ajouter).

## 💻 Mise en place de l'application localement
- Avoir [Docker](https://docs.docker.com/engine/install/) de lancé sur son poste.
- Télécharger le repo `git clone https://github.com/mateja-velickovic/web-educational_app.git`.
- Se rendre dans le répertoire `cd web-educational_app`.
- Ajouter votre clé API dans `\p_prod-jp\src\php\authentication\config.ini.php`.
- Initaliser le projet `sh init.sh`.
- Profiter de l'application dans votre navigateur à l’adresse `localhost:8080`.

### + Profiter des privilèges d'administrateur
Ajouter votre adresse mail dans la liste des utilisateurs admin dans `\p_prod-jp\src\php\authentication\login.php:23`.
