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
    $sql = "SELECT COUNT(*) AS count FROM t_registration WHERE fkUser = :id AND fkActivity = :activity";

    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $idUser, PDO::PARAM_INT);
    $query->bindParam(':activity', $idActivity, PDO::PARAM_INT);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result['count'] > 0;
}


/**
 * Obtenir une activité avec son ID.
 *
 * @param PDO $pdo Objet de connexion à la base de données.
 * @param int $idActivity ID de l'activité.
 */
function getActivityByID(PDO $pdo, int $idActivity)
{
    $sql = "SELECT * FROM t_activity WHERE idActivite = :idActivite";

    $query = $pdo->prepare($sql);
    $query->bindParam(':idActivite', $idActivity, PDO::PARAM_INT);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result;
}

/**
 * Obtenir les participants d'une activités.
 *
 * @param PDO $pdo Objet de connexion à la base de données.
 * @param int $idActivity ID de l'activité.
 */
function getUsersByActivityID(PDO $pdo, int $idActivity)
{
    $sql = "
        SELECT u.*
        FROM t_registration a
        INNER JOIN t_user u ON a.fkUser = u.idUser
        WHERE a.fkActivity = :idActivite
    ";

    $query = $pdo->prepare($sql);
    $query->bindParam(':idActivite', $idActivity, PDO::PARAM_INT);
    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}
