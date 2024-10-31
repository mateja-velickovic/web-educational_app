<?php

/**
 * Récupération du nom et prénom de l'utilisateur grâce à son email et mise en forme de ces derniers
 *
 * @param string $email Email de l'utilisateur 
 */
function GetNameAndSurname($email)
{
    list($prenom, $nom) = explode('.', explode('@', $email)[0]);

    $prenom = ucfirst($prenom);
    $nom = ucfirst($nom);

    return [
        'prenom' => $prenom,
        'nom' => $nom
    ];
}

/**
 * Insertion du compte de l'utilisateur avec ses informations dans la base de données
 *
 * @param string $email Email de l'utilisateur 
 */
function InitiateUser($email)
{
    include "../lib/database.php";

    // Utilisateurs possédant le rôle administrateur par défaut
    $adminUsers = ["mateja.velickovic@eduvaud.ch", "xavier.carrel@eduvaud.ch"];

    $sql = "SELECT * FROM t_user WHERE useEmail = :email";
    $result = $pdo->prepare($sql);
    $result->bindParam(':email', $email);
    $result->execute();

    $data = GetNameAndSurname($email);

    $name = $data['prenom'];
    $surname = $data['nom'];

    // Rôles constants
    $ADMIN_ROLE = 2;
    $USER_ROLE = 1;

    if ($result->rowCount() == 0) {
        $sql_create = "INSERT INTO `t_user`(`useEmail`, `useName`, `useSurname`, `fkRole`) VALUES (?, ?, ?, ?)";
        $result_create = $pdo->prepare($sql_create);
        $result_create->bindParam(1, $email);
        $result_create->bindParam(2, $name);
        $result_create->bindParam(3, $surname);

        if (in_array($email, $adminUsers)) {
            $result_create->bindParam(4, $ADMIN_ROLE);
        } else {
            $result_create->bindParam(4, $USER_ROLE);
        }

        $result_create->execute();
    }

}

/**
 * Récupération des informations des utilisateurs
 *
 * @param string $email Email de l'utilisateur 
 */
function GetUserData($email)
{
    include "../lib/database.php";

    $sql = "SELECT * FROM t_user WHERE useEmail = :email";
    $result = $pdo->prepare($sql);
    $result->bindParam(':email', $email);
    $result->execute();

    if ($result->rowCount() > 0) {
        $user = $result->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    return null;
}