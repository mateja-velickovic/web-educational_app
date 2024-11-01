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
    }

    header('Location: ../admin.php');
}

/**
 * Create a new activity.
 *
 * @param PDO $pdo The database connection object.
 */
function createActivity(PDO $pdo): void
{
    session_start();

    try {
        if ($_SESSION['userrole'] == 2) {
            $sql = "INSERT INTO t_activity (actName, actDesc, actDate, actPlace, actCapacity) 
                VALUES (:name, :desc, :date, :place, :capacity)";

            // Préparer la requête
            $query = $pdo->prepare($sql);

            $query->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
            $query->bindParam(':desc', $_POST['desc'], PDO::PARAM_STR);
            $query->bindParam(':date', $_POST['date'], PDO::PARAM_STR);
            $query->bindParam(':place', $_POST['place'], PDO::PARAM_STR);
            $query->bindParam(':capacity', $_POST['capacity'], PDO::PARAM_INT);

            $query->execute();
        }

        header('Location: ../admin.php');

    } catch (Exception $e) {
        header('Location: ../admin.php?error=create');
    }

}

/**
 * Edit an activity.
 *
 * @param PDO $pdo The database connection object.
 */
function editActivity(PDO $pdo): void
{
    session_start();

    try {
        if ($_SESSION['userrole'] == 2) {
            $edit_activity = "UPDATE t_activity 
                    SET actName = :name, actDesc = :desc, actDate = :date, 
                        actPlace = :place, actCapacity = :capacity 
                    WHERE idActivite = :id";

            // Préparer la requête
            $query = $pdo->prepare($edit_activity);

            $query->bindParam(':id', $_POST['edit'], PDO::PARAM_INT);
            $query->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
            $query->bindParam(':desc', $_POST['desc'], PDO::PARAM_STR);
            $query->bindParam(':date', $_POST['date'], PDO::PARAM_STR);
            $query->bindParam(':place', $_POST['place'], PDO::PARAM_STR);
            $query->bindParam(':capacity', $_POST['capacity'], PDO::PARAM_INT);

            $query->execute();
        }

        header('Location: ../admin.php');

    } catch (Exception $e) {
        header('Location: ../admin.php?error=create');
    }

}



if (isset($_POST['delete'])) {
    require "../lib/database.php";

    deleteActivity($pdo);
}

if (isset($_POST['add'])) {
    require "../lib/database.php";

    createActivity($pdo);
}

if (isset($_POST['edit'])) {
    require "../lib/database.php";

    editActivity($pdo);
}