<?php
session_start();
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
    <title>Administration - Journée Pédagogique</title>
    <link rel="stylesheet" href="../../../resources/css/style.css">
</head>

<body>
    <header>
        <h1 id="t1">ETML - Journée Pédagogique <?php echo date("Y") ?></h1>
        <div class="log">
            <a class="acc" href="../../../index.php">REVENIR À LA PAGE D'ACCUEIL</a>
        </div>
    </header>

    <?php require "lib/database.php"; ?>

    <table class="admin">

        <!-- If any activity exist -->
        <?php if (Count($result) == 0) { ?>
            <h2 style="text-align: center; font-weight: normal; margin-top: 20px;">Aucune activité n'est actuellement créée.
            </h2>
        <?php } else { ?>

            <!-- Titles of activities array -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Date</th>
                    <th>Lieu</th>
                    <th>Capacité</th>
                    <th> </th>
                    <th> </th>
                    <th> </th>
                </tr>
            </thead>
            <?php
            foreach ($result as $row) {
                $registrations = getInscriptionsCount($pdo, $row['idActivite']); ?>

                <tbody>
                    <tr>
                        <td><?php echo $row['idActivite'] ?></td>
                        <td><?php echo $row['actName']; ?></td>
                        <td><?php echo $row['actDate']; ?></td>
                        <td><?php echo $row['actPlace']; ?></td>
                        <td><?php echo $registrations . '/' . $row['actCapacity'] ?></td>

                        <!-- Delete the activity -->
                        <form action="./functions/administration.php" method="POST">
                            <input type="hidden" name="delete" value="<?php echo $row['idActivite']; ?>">
                            <td id="rm"><button type="submit"><img src="../../resources/images/rm.png"
                                        alt="Corbeille pour la supression d'une activité dans la page d'administration"></button>
                            </td>
                        </form>

                        <!-- Edit the activity -->
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
    </table>


    </div>
</body>

</html>