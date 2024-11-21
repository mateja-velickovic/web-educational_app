<?php
session_start();
require "./lib/database.php";
require "./functions/activities.php";
require "./functions/administration.php";

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
    <title>Planning - Journée Pédagogique</title>
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
            <a class="logout" href="./functions/logout.php">Déconnexion</a>
        </div>

    </header>


    <main class="planning">
            <h2>Vos prochaines activités.</h2>

        <div class="user-activities">

            <?php
            $activities = getUserActivites($pdo, $_SESSION['userid']);
            foreach ($activities as $act): ?>

            <div class="ua">


                <p class="date"><?php echo $act['actDate']; ?></p> 

                <form action="./joinActivite.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $act['idActivite']; ?>">
                    <input type="hidden" name="type" value="u-act">
                    <p class="ua-name"><?php echo $act['actName']; ?><button class="icon-leave" onclick="return confirm('Voulez-vous vraiment quitter l\'activité : <?php echo $act['actName']; ?>');"><img id="icon-info" src="../../resources/images/leave.png" alt="Logo pour représenter une porte"></button></p>
                </form>

                <p class="ua-info"><img id="icon-info" src="../../resources/images/place.png" alt="Logo pour représenter l'épingle d'une carte"><?php echo $act['actPlace']; ?></p>
                <p class="ua-info"><img id="icon-info" src="../../resources/images/info.png" alt="Logo pour représenter un I d'information"><?php echo $act['actDesc']; ?></p>
                
            </div>

            <?php endforeach; ?>

        </div>

    </main>


    <footer><a href="https://github.com/mateja-velickovic" target="_blank"><img id="icon-info"
                src="../../resources/images/github.png" alt="Logo de GitHub"></a>Réalisé par Velickovic Mateja -
        Septembre 2024 - Icônes <a href="https://www.flaticon.com" target="_blank">Flaticon</a></footer>
</body>

</html>