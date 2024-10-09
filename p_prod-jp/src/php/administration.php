<?php

/**
 * Check if the user is an administrator.
 *
 * @param PDO $pdo The database connection object.
 * @param int $idUser The ID of the user.
 * @return bool Return true if the user's admin.
 */
function isUserAdmin(PDO $pdo, int $idUser): bool
{
    $sql = "SELECT * FROM t_user WHERE idUser = :id";

    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $idUser, PDO::PARAM_INT);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result === false) {
        return false;
    }


    return $result == "admin";
}
