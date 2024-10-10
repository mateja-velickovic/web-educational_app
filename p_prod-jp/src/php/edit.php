<?php
session_start();
require "./functions/activities.php";
require "./functions/administration.php";
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
        <?php } ?>

        <form class="editact" action="">

            <?php $activity = getActivityByID($pdo, $_POST['edit']); ?>
            <input type="text" name="name" value="<?php echo $activity['actName'] ?>">
            <input type="text" name="date" value="<?php echo $activity['actDate'] ?>">
            <input type="text" name="place" value="<?php echo $activity['actPlace'] ?>">
            <input type="text" name="capacity" value="<?php echo $activity['actCapacity'] ?>">

        </form>


        </tbody>
    </table>


    </div>
</body>

</html>