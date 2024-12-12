<?php
session_start();

require "./functions/activities.php";
require "./lib/database.php";

// If the user isn't an admin, redirect on the home page
if ($_SESSION['userrole'] != 2) {
    header('Location: ../../../index.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification - Journée Pédagogique</title>
    <link rel="stylesheet" href="../../resources/css/style.css">
    <link rel="icon" type="image/png" href="../../resources/images/etml-jp.png" />
</head>

<body>
    <header>
        <div>
            <h1 id="t1">Modification - Journée Pédagogique <?php echo date("Y") ?></h1>
            <p>Connecté en tant que <?php echo $_SESSION['name'] . " " . $_SESSION['surname'] ?></a>
        </div>

        <div class="log">
            <a class="btn-admin" href="../../index.php">Revenir à la page d'accueil</a>
            <a class="logout" href="functions/logout.php">Déconnexion</a>
        </div>

    </header>

    <?php

    try {
        if (isset($_POST['edit'])) {
            $activity = getActivityByID($pdo, $_POST['edit']);
            $_SESSION['edit'] = $_POST['edit'];
        } else {
            throw new Exception("ID d'activité invalide ou manquante.");
        }
    } catch (Exception $e) {
        if (isset($_SESSION['edit'])) {
            $activity = getActivityByID($pdo, $_SESSION['edit']);
        } else {
            echo "Aucune activité à récupérer.";
        }
    }
    ?>

    <div class="edit-main">
        <!-- Modifier une activité -->
        <?php if(isWaitingListEmpty($pdo, $activity['idActivite']) && isActivityEmpty($pdo, $activity['idActivite'])){ ?>
        <div class="edit-left" style="width: 100%; margin: auto;">
        <?php } else { ?>
        <div class="edit-left" style="width: 50%; margin: auto;">
        <?php } ?>

            <form class="edit-act" action="./functions/administration.php" method="POST">

                <input type="hidden" name="edit" value="<?php echo $activity['idActivite']; ?>">

                <p id="ed-info">Nom de l'activité</p>
                <textarea style="max-height: 100px; min-height: 40px;" type="text" name="name" maxlength="50"
                    required><?php echo $activity['actName'] ?></textarea>

                <p id="ed-info">Description</p>
                <textarea style="max-height: 175px; min-height: 40px;" type="text" name="desc" maxlength="100"
                    required><?php echo $activity['actDesc'] ?> </textarea>

                <p id="ed-info">Date</p>
                <input type="datetime-local" name="date" value="<?php echo $activity['actDate'] ?>" required>

                <p id="ed-info">Lieu</p>
                <textarea style="max-height: 100px; min-height: 40px;" type="text" name="place" maxlength="50"
                    required><?php echo $activity['actPlace'] ?></textarea>

                <p id="ed-info">Capacité</p>
                <input type="number" name="capacity" placeholder="Capacité" min="0" max="1000"
                    value="<?php echo $activity['actCapacity'] ?>" required>

                <button type="submit"
                    onclick="return confirm('Voulez-vous vraiment modifier l\'activité n°<?php echo $activity['idActivite']; ?>');">
                    <img src="../../resources/images/validate.png"
                        alt="Stylo orange pour modifier l'activité sélectionnée.">
                </button>
            </form>
        </div>

        <?php if(isWaitingListEmpty($pdo, $activity['idActivite']) && isActivityEmpty($pdo, $activity['idActivite'])){ ?>
        <div class="edit-right" style="width: 0%; margin: auto;">
        <?php } else { ?>
        <div class="edit-right" style="width: 50%; margin: auto;">
        <?php } ?>

            <br>
            <!-- Liste des participants de l'activité avec la possibilité de les supprimer-->
            <form class="disp-par" action="./functions/administration.php" method="POST">

                <?php $result = getUsersByActivityID($pdo, $activity['idActivite']); ?>

                <?php foreach ($result as $row) { ?>

                    <input type="hidden" name="delete_user" value="<?php echo $row['idUser']; ?>">
                    <input type="hidden" name="delete_user_act" value="<?php echo $activity['idActivite']; ?>">

                    <div class="participant">
                        <p style="font-size: 1.2rem">
                            <?php echo $row['useName'] . ' ' . $row['useSurname'] . ' / ' . $row['useEmail'] ?>
                        </p>
                        <button id="delete_user" type="submit"
                            onclick="return confirm('Voulez-vous vraiment supprimer l\'utilisateur : <?php echo $row['useName'] . ' ' . $row['useSurname']; ?>');">
                            <img src="../../resources/images/rm.png" alt="Corbeille rouge pour supprimer un utilisateur.">
                        </button>
                    </div>

                <?php } ?>

            </form>

            <!-- Liste des utilisateurs présents dans la file d'attente -->
            <?php if (!isWaitingListEmpty($pdo, $activity['idActivite'])) { ?>
                <h2 style="text-align:center; color:white; margin-top:20px;">Utilisateurs en attente</h2>
                <form class="disp-par" action="./functions/activities.php" method="POST">

                    <?php $waiting_users = getUsersFromWaitingList($pdo, $activity['idActivite']); ?>

                    <?php foreach ($waiting_users as $wu) { ?>

                        <input type="hidden" name="insert_user" value="<?php echo $wu['idUser']; ?>">
                        <input type="hidden" name="insert_user_act" value="<?php echo $activity['idActivite']; ?>">

                        <div class="participant">
                            <p style="font-size: 1.2rem">
                                <?php echo $wu['useName'] . ' ' . $wu['useSurname'] . ' / ' . $wu['useEmail'] ?>
                            </p>
                            <button id="insert_user" type="submit"
                                onclick="return confirm('Voulez-vous ajouter l\'utilisateur : <?php echo $wu['useName'] . ' ' . $wu['useSurname']; ?> à l\'activité n°<?php echo $activity['idActivite']; ?>');">
                                <img src="../../resources/images/add.png"
                                    alt="Flèche verte pour ajouter un utilisateur à une activité.">
                            </button>
                        </div>

                    <?php } ?>

                </form>
            <?php } ?>
        </div>
    </div>

    <footer>
        <a href="https://github.com/mateja-velickovic" target="_blank">
            <img id="icon-info" src="../../resources/images/github.png" alt="Logo de GitHub"></a>Réalisé par Velickovic
        Mateja -
        Septembre 2024 - Icônes <a href="https://www.flaticon.com" target="_blank">Flaticon</a>
    </footer>
</body>

</html>