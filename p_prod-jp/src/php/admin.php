<?php
session_start();
require "./functions/activities.php";
require "./functions/administration.php";

// On vérifie que l'utilisateur est administrateur
if ($_SESSION['userrole'] != 2) {
    header('Location: ../../../index.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Journée Pédagogique</title>
    <link rel="stylesheet" href="../../../resources/css/style.css">
</head>

<body>
    <header>
        <div>
            <h1 id="t1">Journée Pédagogique <?php echo date("Y") ?></h1>
            <p>Connecté en tant que <?php echo $_SESSION['name'] . " " . $_SESSION['surname'] ?></a>
        </div>
        <div class="log">
            <a class="acc" href="../../../index.php">Revenir à la page d'accueil</a>
            <a class="logout" href="src/php/functions/logout.php">Déconnexion</a>
        </div>

    </header>

    <?php require "lib/database.php"; ?>

    <div style="overflow-x:auto;">

        <table class="admin">

            <?php if (Count($result) == 0) { ?>
                <!-- Si aucune activité n'est présente -->
            <?php } else { ?>
            
                <h2 style=" color: white; text-align: center; font-weight: normal; margin-top: 20px;">Liste des activités.
                </h2>

                <div class="admin-array">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Capacité</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <?php

                    // Tableau qui affiche toutes les activités
                    foreach ($result as $row) {
                        $registrations = getInscriptionsCount($pdo, $row['idActivite']); ?>

                        <tbody>
                            <tr>

                                <td><?php echo $row['actName']; ?></td>
                                <td><?php echo $row['actDesc']; ?></td>
                                <td><?php echo $row['actDate']; ?></td>
                                <td><?php echo $registrations . '/' . $row['actCapacity'] ?></td>

                                <!-- Modifier une activité -->
                                <form action="./edit.php" method="POST">
                                    <input type="hidden" name="edit" value="<?php echo $row['idActivite']; ?>">
                                    <td id="ed"><button type="submit"><img src="../../resources/images/ed.png"
                                                alt="Stylo pour la modification d'une activité dans la page d'administration"></button>
                                    </td>
                                </form>

                                <!-- Supprimer une activité -->
                                <form action="./functions/administration.php" method="POST">
                                    <input type="hidden" name="delete" value="<?php echo $row['idActivite']; ?>">
                                    <td id="rm"><button type="submit"
                                            onclick="return confirm('Voulez-vous vraiment supprimer l\'activité n°<?php echo $row['idActivite']; ?>');"><img
                                                src="../../resources/images/rm.png"
                                                alt="Corbeille pour la supression d'une activité dans la page d'administration"></button>
                                    </td>
                                </form>

                                <p>

                            </tr>
                        <?php }
            } ?>
                </tbody>
            </div>

        </table>
    </div>

    <!-- Créer une nouvelle activité -->
    <h2 style="color: white; text-align: center; font-weight: normal; margin-top: 10px; margin-bottom: 20px;">Créez une nouvelle
        activité.</h2>

        <form class="insert-act" action="./functions/administration.php" method="POST">
                
                <input type="hidden" name="add">

                <textarea style="max-height: 100px; min-height: 40px;" type="text" placeholder="Nom de l'activité (max 50c)" name="name" maxlength="50"></textarea required>
            
                <textarea style="max-height: 175px; min-height: 40px;" type="text" placeholder="Description (max 100c)" name="desc" maxlength="100"></textarea required>
                
                <input type="datetime-local" name="date" required>
                
                <textarea style="max-height: 100px; min-height: 40px;" placeholder="Lieu" type="text" name="place" maxlength="50"></textarea required>
                
                <input type="number" name="capacity" min="0" max="1000" placeholder="Capacité" required>
    
                <button type="submit">
                <img src="../../resources/images/add.png" alt="Flèche verte pour créer une nouvelle activité.">
                </button>
    
            </form>


        <?php if (isset($_GET['error']) && $_GET['error'] == "create") { ?>
            <p style="color: rgb(161, 0, 0); font-size: 1.2rem; text-align: center; font-weight: normal; margin-top: 20px;">
                Échec de la
                création de l'activité, veuillez réessayer.
            </p>
        <?php } else {
        } ?>

        <footer><a href="https://github.com/mateja-velickovic" target="_blank"><img id="icon-info"
                    src="../../resources/images/github.png" alt=""></a>Réalisé par Velickovic Mateja -
            Septembre 2024 - Icônes <a href="https://www.flaticon.com" target="_blank">Flaticon</a></footer>

</body>

</html>