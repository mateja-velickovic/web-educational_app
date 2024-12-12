<?php

/**
 * Obtenir le nombre d'inscrits à une acitivité.
 *
 * @param PDO $pdo Objet de connexion à la base de données.
 * @param int $idActivity ID de l'activité.
 * @return int On retourne le nombre d'inscrits à l'activité.
 */
function getInscriptionsCount(PDO $pdo, int $idActivite): int
{
    $sql = "SELECT COUNT(*) AS insc FROM t_registration WHERE fkActivity = :id";

    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $idActivite, PDO::PARAM_INT);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);

    return (int) $result['insc'];
}

/**
 * Vérifier si une activité est pleine ou pas.
 *
 * @param PDO $pdo Objet de connexion à la base de données.
 * @param int $idActivity ID de l'activité.
 * @return bool On retourne vrai si l'activité est pleine.
 */
function isActivityFull(PDO $pdo, int $idActivity): bool
{
    $registrations = getInscriptionsCount($pdo, $idActivity);

    $sql = "SELECT actCapacity AS capacity FROM t_activity WHERE idActivite = :id";
    $query = $pdo->prepare($sql);

    $query->bindParam(':id', $idActivity, PDO::PARAM_INT);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result === false) {
        return false;
    }

    return $registrations >= $result['capacity'];
}

/**
 * Vérifier si un utilisater a rejoint une activité avec son ID.
 *
 * @param PDO $pdo Objet de connexion à la base de données.
 * @param int $idActivity ID de l'activité.
 * @param int $idUser ID de l'utilisateur.
 * @return bool On retourne vrai si l'utilisateur a rejoint l'activité.
 */
function hasUserJoined(PDO $pdo, int $idActivity, int $idUser)
{
    try {
        $sql = "SELECT COUNT(*) AS count FROM t_registration WHERE fkUser = :id AND fkActivity = :activity";

        $query = $pdo->prepare($sql);
        $query->bindParam(':id', $idUser, PDO::PARAM_INT);
        $query->bindParam(':activity', $idActivity, PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    } catch (Exception $e) {
        echo "Erreur lors de la récupération des données...";
        return false;
    }
}

/**
 * Obtenir une activité avec son ID.
 *
 * @param PDO $pdo Objet de connexion à la base de données.
 * @param int $idActivity ID de l'activité.
 */
function getActivityByID(PDO $pdo, int $idActivity)
{
    try {
        $sql = "SELECT * FROM t_activity WHERE idActivite = :idActivite";

        $query = $pdo->prepare($sql);
        $query->bindParam(':idActivite', $idActivity, PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result;
    } catch (Exception $e) {
        echo "Erreur lors de la récupération des données...";
        return $e;
    }
}

/**
 * Obtenir les participants d'une activités.
 *
 * @param PDO $pdo Objet de connexion à la base de données.
 * @param int $idActivity ID de l'activité.
 */
function getUsersByActivityID(PDO $pdo, int $idActivity)
{
    try {
        $sql = "
            SELECT u.*
            FROM t_registration a
            INNER JOIN t_user u ON a.fkUser = u.idUser
            WHERE a.fkActivity = :idActivite";

        $query = $pdo->prepare($sql);
        $query->bindParam(':idActivite', $idActivity, PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (Exception $e) {
        echo "Erreur lors de la récupération des données...";
    }
}

/**
 * Remplir les activités si elles se vident et que la fille d'attente n'est pas vide
 *
 * @param PDO $pdo Objet de connexion à la base de données.
 */
function fillActivites(PDO $pdo)
{
    try {

        $actQuery = "SELECT * FROM t_activity";
        $getactivities = $pdo->prepare($actQuery);
        $getactivities->execute();
        $result = $getactivities->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
        exit();
    }

    foreach ($result as $activity) {
        if (!isActivityFull($pdo, $activity['idActivite']) && !isWaitingListEmpty($pdo, $activity['idActivite'])) {
            $users = getUsersIDFromWaitingList($pdo, $activity['idActivite']);

            foreach ($users as $u) {
                echo $u['fkUser'];

                // Ajout de l'utilisateur dans l'activité
                insertUserIntoActivity($pdo, $u['fkUser'], $activity['idActivite']);

                // Suppression de l'utilisateur de la file d'attente
                removeUserFromWaitingList($pdo, $u['fkUser'], $activity['idActivite']);
            }
        }
    }
}

/**
 * Retourne vrai si la liste d'attente de l'activité est vide
 *
 * @param PDO $pdo Objet de connexion à la base de données.
 * @param int $idActivity ID de l'activité
 */
function isWaitingListEmpty(PDO $pdo, int $idActivity)
{
    try {
        $sql = "SELECT 1 FROM t_waiting WHERE fkActivity = :activity LIMIT 1";

        $query = $pdo->prepare($sql);
        $query->bindParam(':activity', $idActivity, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC) === false;
    } catch (Exception $e) {
        error_log("Erreur lors de la récupération des données : " . $e->getMessage());
        return false;
    }
}

/**
 * Ajout d'un utilisateur de la file d'attente dans l'activité
 *
 * @param PDO $pdo Objet de connexion à la base de données.
 * @param int $idUser ID de l'utilisateur
 * @param int $idActivity ID de l'activité
 */
function insertUserIntoActivity(PDO $pdo, int $idUser, int $idActivity)
{
    $insertUser = "INSERT INTO `t_registration` (`fkUser`, `fkActivity`) VALUES (:fkUser, :fkActivity)";

    $insert = $pdo->prepare($insertUser);

    $insert->bindParam(':fkUser', $idUser, PDO::PARAM_INT);
    $insert->bindParam(':fkActivity', $idActivity, PDO::PARAM_INT);

    // Exécuter la requête
    $insert->execute();
}

/**
 * Suppression d'un utilisateur de la file d'attente lorsqu'il a été ajouté à l'activité
 *
 * @param PDO $pdo Objet de connexion à la base de données.
 * @param int $idUser ID de l'utilisateur
 * @param int $idActivity ID de l'activité
 */
function removeUserFromWaitingList(PDO $pdo, int $idUser, int $idActivity)
{
    try {

        $removeUser = "DELETE FROM `t_waiting` WHERE fkUser = :fkUser AND fkActivity = :fkActivity";

        $remove = $pdo->prepare($removeUser);

        $remove->bindParam(':fkUser', $idUser, PDO::PARAM_INT);
        $remove->bindParam(':fkActivity', $idActivity, PDO::PARAM_INT);

        // Exécuter la requête
        $remove->execute();

    } catch (Exception $e) {
        return $e->getMessage();
    }

}

/**
 * Récupération des ID utilisateurs de la file d'attente selon la place libérée
 *
 * @param PDO $pdo Objet de connexion à la base de données.
 * @param int $idUser ID de l'utilisateur
 * @param int $idActivity ID de l'activité
 */
function getUsersIDFromWaitingList(PDO $pdo, int $idActivity)
{
    $getUsersID = "SELECT fkUser FROM t_waiting WHERE fkActivity = :fkActivity ORDER BY idWaiting ASC LIMIT :remaining";

    $get = $pdo->prepare($getUsersID);
    $get_activity = getActivityByID($pdo, $idActivity);
    $remaining_places = $get_activity['actCapacity'] - getInscriptionsCount($pdo, $idActivity);

    $get->bindParam(':fkActivity', $idActivity, PDO::PARAM_INT);
    $get->bindParam(':remaining', $remaining_places, PDO::PARAM_INT);

    // Exécuter la requête
    $get->execute();

    $users = $get->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}


/**
 * Récupération de tous les utilisateurs présents dans la liste d'attente d'une activité
 *
 * @param PDO $pdo Objet de connexion à la base de données.
 * @param int $idUser ID de l'utilisateur
 * @param int $idActivity ID de l'activité
 */
function getUsersFromWaitingList(PDO $pdo, int $idActivity)
{
    $getUsers = "
            SELECT u.*
            FROM t_user u
            INNER JOIN t_waiting w ON u.idUser = w.fkUser
            WHERE u.idUser = w.fkUser AND w.fkActivity = :fkActivity";

    $get = $pdo->prepare($getUsers);

    $get->bindParam(':fkActivity', $idActivity, PDO::PARAM_INT);

    // Exécuter la requête
    $get->execute();

    $users = $get->fetchAll(PDO::FETCH_ASSOC);
    return $users;
}

/**
 * Vérifier si l'utilisateur est présent ou non dans la liste d'attente de l'activité
 *
 * @param PDO $pdo Objet de connexion à la base de données.
 * @param int $idUser ID de l'utilisateur
 * @param int $idActivity ID de l'activité
 */
function isUserOnWaitingList(PDO $pdo, int $idUser, int $idActivity)
{
    try {
        $sql = "SELECT COUNT(*) AS count FROM t_waiting WHERE fkUser = :id AND fkActivity = :activity";

        $query = $pdo->prepare($sql);
        $query->bindParam(':id', $idUser, PDO::PARAM_INT);
        $query->bindParam(':activity', $idActivity, PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    } catch (Exception $e) {
        echo "Erreur lors de la récupération des données...";
        return false;
    }
}

/**
 * Récupérer les activités d'un utilisateur
 *
 * @param PDO $pdo Objet de connexion à la base de données.
 * @param int $idUser ID de l'utilisateur
 */
function getUserActivites(PDO $pdo, int $idUser)
{
    try {
        $sql = "
            SELECT a.*
            FROM t_activity a
            INNER JOIN t_registration u ON a.idActivite = u.fkActivity
            WHERE u.fkUser = :idUser
            ORDER BY a.actDate ASC";

        $query = $pdo->prepare($sql);
        $query->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    } catch (Exception $e) {
        echo "Erreur lors de la récupération des données...";
    }
}

if (isset($_POST['insert_user_act'])) {
    require "../lib/database.php";
    insertUserIntoActivity($pdo, $_POST['insert_user'], $_POST['insert_user_act']);
    removeUserFromWaitingList($pdo, $_POST['insert_user'], $_POST['insert_user_act']);
    header('Location: ../edit.php');
}