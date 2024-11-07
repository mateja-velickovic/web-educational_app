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


    <main class="planning">
        <?php fillActivites($pdo); ?>
    </main>


    <footer><a href="https://github.com/mateja-velickovic" target="_blank"><img id="icon-info"
                src="../../resources/images/github.png" alt="Logo de GitHub"></a>Réalisé par Velickovic Mateja -
        Septembre 2024 - Icônes <a href="https://www.flaticon.com" target="_blank">Flaticon</a></footer>
</body>

</html>