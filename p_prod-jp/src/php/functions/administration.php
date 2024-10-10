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
    $sql = "SELECT r.rolName 
            FROM t_user AS u
            JOIN t_role AS r ON u.fkRole = r.idRole
            WHERE u.idUser = :id";

    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $idUser, PDO::PARAM_INT);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result === false) {
        return false;
    }

    return $result['rolName'] === 'admin';
}

/**
 * Delete the activity selected by the administrator.
 *
 * @param PDO $pdo The database connection object.
 */
function deleteActivity(PDO $pdo): void
{
    session_start();

    if ($_SESSION['userrole'] == 2) {

        $sql = "DELETE from t_activity WHERE idActivite = :idActivite ";

        $query = $pdo->prepare($sql);
        $query->bindParam(':idActivite', $_POST['delete'], PDO::PARAM_INT);
        $query->execute();
        header('Location: ../admin.php');
    } else {
        echo "Vous n'êtes pas autorisé à effectuer cette action";
    }
}

if (isset($_POST['delete'])) {
    require "../lib/database.php";

    deleteActivity($pdo);
}