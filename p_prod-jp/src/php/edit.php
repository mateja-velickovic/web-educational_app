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

    <h2 style="color: #cccccc; text-align: center; font-weight: normal; margin-top: 20px;">Modifiez l'activité n°
        <?php echo $activity['idActivite'] ?>.

        <!-- Modifier une activité -->
        <form class="edit-act" action="./functions/administration.php" method="POST">
            <input type="hidden" name="edit" value="<?php echo $activity['idActivite']; ?>">

            <p id="ed-info">Nom de l'activité</p>
            <input type="text" name="name" maxlength="50" value="<?php echo $activity['actName'] ?>" required>
            <p id="ed-info">Description</p>
            <textarea type="text" name="desc" maxlength="100"><?php echo $activity['actDesc'] ?>
                 </textarea required>
            <p id="ed-info">Date</p>
            <input type="datetime-local" name="date" value="<?php echo $activity['actDate'] ?>" required>
            <p id="ed-info">Lieu</p>
            <input type="text" name="place" placeholder="Lieu" maxlength="50"
                value="<?php echo $activity['actPlace'] ?>" required>
            <p id="ed-info">Capacité</p>
            <input type="number" name="capacity" placeholder="Capacité" min="0" max="1000"
                value="<?php echo $activity['actCapacity'] ?>" required>

            <button type="submit" onclick="return confirm('Voulez-vous vraiment modifier l\'activité n°<?php echo $activity['idActivite']; ?>');" >
                <img src="../../resources/images/ed.png" alt="Flèche verte pour modifier une activité existante.">
            </button>

        </form>

        <h2 style="color: #cccccc; text-align: center; font-weight: normal; margin-top: 20px;">Participants de
            l'activité n°<?php echo $activity['idActivite'] ?>.</h2>
            

            <!-- Liste des participants de l'activité -->
            <form class="disp-par" action="./functions/administration.php" method="POST">

                <?php $result = getUsersByActivityID($pdo, $activity['idActivite']) ?>

                <?php foreach ($result as $row) { ?>


                    <div class="participant" >

                        <p style="font-size: 1.2rem"><?php echo $row['idUser'] . ' ' . $row['useName'] . ' ' . $row['useSurname'] ?></p>
                        <button type="submit">
                            <img src="../../resources/images/rm.png" alt="Flèche verte pour créer une nouvelle activité.">
                        </button>

                    </div>
                    
                <?php } ?>

            </form>

            <footer><a href="https://github.com/mateja-velickovic" target="_blank"><img id="icon-info"
                        src="../../resources/images/github.png" alt=""></a>Réalisé par Velickovic Mateja -
                Septembre 2024 - Icônes <a href="https://www.flaticon.com" target="_blank">Flaticon</a></footer>
</body>

</html>