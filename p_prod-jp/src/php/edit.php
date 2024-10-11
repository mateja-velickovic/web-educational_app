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
        <h1 id="t1">ETML - Journée Pédagogique <?php echo date("Y") ?></h1>
        <div class="log">
            <a class="btn-admin" href="admin.php">REVENIR À LA PAGE D'ADMINISTRATION</a>
        </div>
    </header>

    <?php $activity = getActivityByID($pdo, $_POST['edit']); ?>

        <h2 style="text-align: center; font-weight: normal; margin-top: 20px;">Modifiez l'activité n° <?php echo $activity['idActivite']?>.

        <form class="edit-act" action="./functions/administration.php" method="POST">

        
            <input type="hidden" name="add">
            <input type="text" name="name" placeholder="Nom de l'activité"  maxlength="30" value="<?php echo $activity['actName'] ?>" required>
            <input type="datetime-local" name="date" value="<?php echo $activity['actDate'] ?>" required>
            <input type="text" name="place" placeholder="Lieu" maxlength="50" value="<?php echo $activity['actPlace'] ?>" required >
            <input type="number" name="capacity" placeholder="Capacité" min="0" max="1000" value="<?php echo $activity['actCapacity'] ?>" required >

            <button type="submit">
                <img src="../../resources/images/ed.png" alt="Flèche verte pour créer une nouvelle activité.">
            </button>

        </form>

        <h2 style="text-align: center; font-weight: normal; margin-top: 20px;">Participants de l'activité n° <?php echo $activity['idActivite']?>.

        <form class="disp-par" action="./functions/administration.php" method="POST">

        <?php $result = getUsersByActivityID($pdo, $activity['idActivite']) ?>

        <?php foreach($result as $row) {?>

        <div class="participant">

            
            <p style="font-size: 1.2rem"><?php echo $row['idUser'] . ' ' . $row['useUsername']?></p>
            <button type="submit">
                <img src="../../resources/images/rm.png" alt="Flèche verte pour créer une nouvelle activité.">
            </button>

        </div>
        <?php }?>


        </form>

    <footer>Réalisé par Velickovic Mateja - Septembre 2024 - Icônes <a href="www.flaticon.com">Flaticon</a></footer>

</body>

</html>