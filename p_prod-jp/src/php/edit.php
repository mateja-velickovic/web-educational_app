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
            <h1 id="t1">Journée Pédagogique <?php echo date("Y") ?></h1>
            <p>Connecté en tant que <?php echo $_SESSION['name'] . " " . $_SESSION['surname'] ?></a>
        </div>

        <div class="log">
            <a class="btn-admin" href="../../index.php">Revenir à la page d'accueil</a>
            <a class="logout" href="src/php/functions/logout.php">Déconnexion</a>
        </div>

    </header>

    <?php $activity = getActivityByID($pdo, $_POST['edit']); ?>

    <!-- Modifier une activité -->
    <div class="edit-main">

        <div class="edit-left">
            <form class="edit-act" action="./functions/administration.php" method="POST">

                <input type="hidden" name="edit" value="<?php echo $activity['idActivite']; ?>">

                <p id="ed-info">Nom de l'activité</p>
                <textarea style="max-height: 100px; min-height: 40px;" type="text" name="name" maxlength="50"><?php echo $activity['actName'] ?></textarea required>
            
                <p id="ed-info">Description</p>
                <textarea style="max-height: 175px; min-height: 40px;" type="text" name="desc" maxlength="100"><?php echo $activity['actDesc'] ?> </textarea required>
                
                <p id="ed-info">Date</p>
                <input type="datetime-local" name="date" value="<?php echo $activity['actDate'] ?>" required>
                
                <p id="ed-info">Lieu</p>
                <textarea style="max-height: 100px; min-height: 40px;" type="text" name="place" maxlength="50"><?php echo $activity['actPlace'] ?></textarea required>
                
                <p id="ed-info">Capacité</p>
                <input type="number" name="capacity" placeholder="Capacité" min="0" max="1000" value="<?php echo $activity['actCapacity'] ?>" required>
    
                <button type="submit" onclick="return confirm('Voulez-vous vraiment modifier l\'activité n°<?php echo $activity['idActivite']; ?>');" >
                    <img src="../../resources/images/validate.png" alt="Stylo orange pour modifier l'activité sélectionnée.">
                </button>
    
            </form>
     </div>

    <div class="edit-right">
            <h2 style="color: white; text-align: center; font-weight: normal; margin: 20px 0px 20px 0px;">Participants de l'activité n°<?php echo $activity['idActivite'] ?>.</h2>
            
            <!-- Liste des participants de l'activité avec la possibilité de les supprimer-->
            <form class="disp-par" action="./functions/administration.php" method="POST">

                <?php $result = getUsersByActivityID($pdo, $activity['idActivite']); ?>
                
                    <?php foreach ($result as $row) { ?>

                        <input type="hidden" name="delete_user" value="<?php echo $row['idUser']; ?>">
                        <input type="hidden" name="delete_user_act" value="<?php echo $activity['idActivite']; ?>">

                            <div class="participant">
                                <p style="font-size: 1.2rem"><?php echo $row['useName'] . ' ' . $row['useSurname'] . ' / ' . $row['useEmail'] ?></p>
                                <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer l\'utilisateur : <?php echo $row['useName'] . ' ' . $row['useSurname']; ?>');">
                                    <img src="../../resources/images/rm.png" alt="Corbeille rouge pour supprimer un utilisateur.">
                                </button>
                            </div>
                    <?php } ?>
            
            </form>
    </div>
     </div>


            <footer><a href="https://github.com/mateja-velickovic" target="_blank"><img id="icon-info"
                        src="../../resources/images/github.png" alt="Logo de GitHub"></a>Réalisé par Velickovic Mateja -
                Septembre 2024 - Icônes <a href="https://www.flaticon.com" target="_blank">Flaticon</a></footer>
</body>

</html>