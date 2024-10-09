<?php

/**
 * Get the number of registrations for a specific activity.
 *
 * @param PDO $pdo The database connection object.
 * @param int $idActivite The ID of the activity.
 * @return int The number of registrations for the activity.
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
 * Check if an activity is full or not.
 *
 * @param PDO $pdo The database connection object.
 * @param int $idActivity The ID of the activity.
 * @return bool True if the user has joined the activity, otherwise false.
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
 * Check if a specific user has joined a specific activity.
 *
 * @param PDO $pdo The database connection object.
 * @param int $idActivity The ID of the activity.
 * @param int $idUser The ID of the user.
 * @return bool True if the user has joined the activity, otherwise false.
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
