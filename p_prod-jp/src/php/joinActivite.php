<?php
session_start();

include "lib/config.php";
include "lib/database.php";
include "functions/activities.php";


$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$hasUserJoined = hasUserJoined($pdo, $_POST['id'], $_SESSION['userid']);
$isActivityFull = isActivityFull($pdo, $_POST['id']);


if (isset($pdo)) {
    // Si l'utilisateur n'a pas rejoint l'activité alors
    if (!$hasUserJoined && !$isActivityFull) {
        $joinActQuery = "INSERT INTO `t_registration` (`fkUser`, `fkActivity`) VALUES (:fkUser, :fkActivity)";

        $joinAct = $pdo->prepare($joinActQuery);

        $joinAct->bindParam(':fkUser', $_SESSION['userid'], PDO::PARAM_INT);
        $joinAct->bindParam(':fkActivity', $_POST['id'], PDO::PARAM_INT);

        // Exécuter la requête
        $joinAct->execute();

    }
    // Si l'utilisateur a déjà rejoint l'activité alors
    if ($hasUserJoined) {
        $leaveActQuery = "DELETE FROM `t_registration` WHERE fkUser = :fkUser AND fkActivity = :fkActivity";

        $leaveAct = $pdo->prepare($leaveActQuery);

        $leaveAct->bindParam(':fkUser', $_SESSION['userid'], PDO::PARAM_INT);
        $leaveAct->bindParam(':fkActivity', $_POST['id'], PDO::PARAM_INT);

        // Exécuter la requête
        $leaveAct->execute();
    }
    header("Location: ../../../index.php");

} else {
    echo "Connecteur PDO non trouvé.";
}
