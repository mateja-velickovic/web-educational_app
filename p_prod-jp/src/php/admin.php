<?php
session_start();
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
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Date</th>
                <th>Lieu</th>
                <th>Capacité</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['idActivite']); ?></td>
                    <td><?php echo htmlspecialchars($row['actName']); ?></td>
                    <td><?php echo htmlspecialchars($row['actDate']); ?></td>
                    <td><?php echo htmlspecialchars($row['actPlace']); ?></td>
                    <td><?php echo htmlspecialchars($row['actCapacity']); ?></td>
                    <td><a href="">X</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>


    </div>
</body>

</html>