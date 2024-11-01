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

    <table class="admin">

        <!-- Si aucune activité n'est présente -->
        <?php if (Count($result) == 0) { ?>
            <h2 style="color: #CCCCCC; text-align: center; font-weight: normal; margin-top: 20px;">Aucune activité n'est
                actuellement créée.
            </h2>
        <?php } else { ?>

            <div class="admin-array">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Lieu</th>
                        <th>Capacité</th>
                        <th> </th>
                        <th> </th>
                        <th> </th>
                    </tr>
                </thead>
                <?php
                // Tableau qui affiche toutes les activités
                foreach ($result as $row) {
                    $registrations = getInscriptionsCount($pdo, $row['idActivite']); ?>

                    <tbody>
                        <tr>
                            <td><?php echo $row['idActivite'] ?></td>
                            <td><?php echo $row['actName']; ?></td>
                            <td><?php echo $row['actDesc']; ?></td>
                            <td><?php echo $row['actDate']; ?></td>
                            <td><?php echo $row['actPlace']; ?></td>
                            <td><?php echo $registrations . '/' . $row['actCapacity'] ?></td>

                            <!-- Supprimer une activité -->
                            <form action="./functions/administration.php" method="POST">
                                <input type="hidden" name="delete" value="<?php echo $row['idActivite']; ?>">
                                <td id="rm"><button type="submit"><img src="../../resources/images/rm.png"
                                            alt="Corbeille pour la supression d'une activité dans la page d'administration"></button>
                                </td>
                            </form>

                            <!-- Modifier une activité -->
                            <form action="./edit.php" method="POST">
                                <input type="hidden" name="edit" value="<?php echo $row['idActivite']; ?>">
                                <td id="ed"><button type="submit"><img src="../../resources/images/ed.png"
                                            alt="Stylo pour la modification d'une activité dans la page d'administration"></button>
                                </td>
                            </form>

                        </tr>
                    <?php }
        } ?>
            </tbody>
        </div>

    </table>

    <!-- Créer une nouvelle activité -->
    <h2 style="color: #CCCCCC; text-align: center; font-weight: normal; margin-top: 20px;">Créez une nouvelle activité.

        <form class="insert-act" action="./functions/administration.php" method="POST">

            <br>
            <input type="hidden" name="add">

            <input type="text" name="name" placeholder="Nom de l'activité" maxlength="30" required>
            <input type="text" name="desc" placeholder="Description" maxlength="50" required>
            <input type="datetime-local" name="date" required>
            <input type="text" name="place" placeholder="Lieu" maxlength="50" required>
            <input type="number" name="capacity" placeholder="Places" min="0" max="1000" required>

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