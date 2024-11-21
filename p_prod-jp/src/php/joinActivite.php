<?php
session_start();

include "lib/database.php";
include "functions/activities.php";


$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$hasUserJoined = hasUserJoined($pdo, $_POST['id'], $_SESSION['userid']);
$hasUserJoined_waiting = isUserOnWaitingList($pdo, $_SESSION['userid'], $_POST['id']);
$isActivityFull = isActivityFull($pdo, $_POST['id']);


if (isset($pdo)) {

    // Si l'utilisateur n'a pas rejoint l'activité et qu'elle est pas pleine alors : Rejoindre
    if (!$hasUserJoined && !$isActivityFull) {
        $joinActQuery = "INSERT INTO `t_registration` (`fkUser`, `fkActivity`) VALUES (:fkUser, :fkActivity)";

        $joinAct = $pdo->prepare($joinActQuery);

        $joinAct->bindParam(':fkUser', $_SESSION['userid'], PDO::PARAM_INT);
        $joinAct->bindParam(':fkActivity', $_POST['id'], PDO::PARAM_INT);

        // Exécuter la requête
        $joinAct->execute();

    }

    // Si l'utilisateur a déjà rejoint l'activité alors : Quitter
    if ($hasUserJoined) {
        $leaveActQuery = "DELETE FROM `t_registration` WHERE fkUser = :fkUser AND fkActivity = :fkActivity";

        $leaveAct = $pdo->prepare($leaveActQuery);

        $leaveAct->bindParam(':fkUser', $_SESSION['userid'], PDO::PARAM_INT);
        $leaveAct->bindParam(':fkActivity', $_POST['id'], PDO::PARAM_INT);

        // Exécuter la requête
        $leaveAct->execute();

    }

    // Si l'utilisateur n'a pas rejoint l'acitivité et qu'elle est pleine : File d'attente
    if (!$hasUserJoined && $isActivityFull) {
        $joinActQuery = "INSERT INTO `t_waiting` (`fkUser`, `fkActivity`) VALUES (:fkUser, :fkActivity)";

        $joinAct = $pdo->prepare($joinActQuery);

        $joinAct->bindParam(':fkUser', $_SESSION['userid'], PDO::PARAM_INT);
        $joinAct->bindParam(':fkActivity', $_POST['id'], PDO::PARAM_INT);

        // Exécuter la requête
        $joinAct->execute();
    }

    // Si l'utilisateur est présent dans la file d'attente : Quitter File d'attente
    if ($hasUserJoined_waiting) {
        $leaveWaitQuery = "DELETE FROM `t_waiting` WHERE fkUser = :fkUser AND fkActivity = :fkActivity";

        $leaveWait = $pdo->prepare($leaveWaitQuery);

        $leaveWait->bindParam(':fkUser', $_SESSION['userid'], PDO::PARAM_INT);
        $leaveWait->bindParam(':fkActivity', $_POST['id'], PDO::PARAM_INT);

        // Exécuter la requête
        $leaveWait->execute();
    }

    if(!isset($_POST['type'])){
        header("Location: ../../../index.php");
    }
    else {
        header("Location: ./planning.php");
    }

} else {
    echo "Connecteur PDO non trouvé.";
}
