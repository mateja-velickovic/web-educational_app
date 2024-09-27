<?php
session_start();

require "src/php/config.php";
include "src/php/lib/database.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ETML - Journée Pédagogique</title>
    <link rel="stylesheet" href="resources/css/style.css" />
</head>

<body>

    <header>
        <p id="t1">ETML - Journée Pédagogique</p>
        <?php if (!isset($_SESSION['loggedin'])) { ?>
            <p id="info">Bienvenue sur le site de la Journée Pédagogique de l'ETML. Connectez-vous pour avoir accès au reste
                du
                site.
            <p>
            </p>
            <div class="log">
            <?php } ?>
            <?php if (!isset($_SESSION['loggedin'])) { ?>
                <a class="login" href="src/php/login.php">SE CONNECTER</a>
            <?php } ?>
            <?php if (!isset($_SESSION['loggedin'])) { ?>
            </div>
        <?php } ?>
        <?php if (isset($_SESSION['loggedin'])) { ?>
            <p id="connected">Connecté en tant que
                <?php echo $_SESSION['username'] ?>
            </p>
            <?php if (isset($_SESSION['loggedin'])) { ?>
                <a class="logout" href="src/php/logout.php">SE DÉCONNECTER</a>
            <?php } ?>
        <?php } ?>
    </header>

    <?php if (isset($_SESSION['loggedin'])) { ?>
        <main>
            <div class="grp-activite">
                <?php
                require "./src/php/config.php";
                require "./src/php/lib/database.php";
                require "./src/php/activities.php";
                foreach ($result as $row) { ?>
                    <div class="activite">

                        <?php
                        $inscriptions = getInscriptionsCount($pdo, $row['idActivite']);
                        $hasUserJoined = hasUserJoined($pdo, $id['idActivite']);
                        ?>

                        <p><?php echo $row['actLibelle'] ?></p>
                        <p><?php echo $row['actDate'] ?></p>
                        <p><?php echo $inscriptions ?>/<?php echo $row['actCapacite'] ?> place(s) restante(s)</p>
                        <p><?php echo $row['actLieu'] ?></p>

                        <form action="src/php/joinActivite.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $row['idActivite'] ?>">
                            <button type="submit">REJOINDRE<br>L'ACTIVITÉ</button>
                        </form>
                    </div>

                <?php } ?>
            </div>
        </main>
    <?php } ?>

    <?php if (!isset($_SESSION['loggedin'])) { ?>
        <div class="infoacc">
            <h1>La journée pédagogique en quelques phrases...</h1>
            <div class="grp-info">
                <img src="resources/images/amp.png" alt="">
                <p>"L'enseignement évolue constamment, et il est essentiel d'adopter des méthodes innovantes pour capter
                    l'attention des élèves. Cette journée pédagogique sera l'occasion d'explorer de nouveaux outils et
                    approches pour rendre l'apprentissage plus interactif et stimulant. Ensemble, redéfinissons les
                    pratiques pour répondre aux besoins d'une génération connectée et en quête de sens."</p>
            </div>
            <div class="grp-info">
                <img src="resources/images/coop.png" alt="">
                <p>"La collaboration est la clé du succès dans l'enseignement. Cette journée vise à renforcer les liens
                    entre les enseignants, à échanger sur les bonnes pratiques et à apprendre les uns des autres. Ensemble,
                    nous pouvons construire une communauté éducative plus forte, où chaque enseignant apporte sa pierre à
                    l'édifice pour offrir aux élèves la meilleure expérience d'apprentissage possible."</p>
            </div>
            <div class="grp-info">
                <img src="resources/images/divers.png" alt="">
                <p>"Créer un environnement inclusif est l'une des priorités majeures de l'éducation moderne. Comment adapter
                    nos pratiques pédagogiques pour répondre aux besoins de chaque élève, quel que soit son parcours ou ses
                    spécificités ? Lors de cette journée, nous aborderons les outils et stratégies pour favoriser
                    l'inclusion, afin que chaque élève trouve sa place et s'épanouisse au sein de la classe."</p>
            </div>
            <div class="grp-info">
                <img src="resources/images/bienetre.png" alt="">
                <p>"Le bien-être au sein de l'école est crucial pour garantir un environnement propice à l'apprentissage.
                    Cette journée portera sur des techniques pour améliorer la gestion du stress, favoriser l'équilibre vie
                    personnelle-vie professionnelle et créer des espaces de bien-être pour les enseignants et les élèves.
                    Prenons soin de nous pour mieux accompagner nos élèves dans leur parcours scolaire."</p>
            </div>
        </div>
    <?php } ?>



</body>

</html>