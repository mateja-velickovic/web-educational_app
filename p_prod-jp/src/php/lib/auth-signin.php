<?php

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

function InitiateUser($email)
{
    include "database.php";

    $sql = "SELECT * FROM t_user WHERE useEmail = :email";
    $result = $pdo->prepare($sql);
    $result->bindParam(':email', $email);
    $result->execute();

    $data = GetNameAndSurname($email);

    $name = $data['prenom'];
    $surname = $data['nom'];

    if ($result->rowCount() == 0) {
        $sql_create = "INSERT INTO `t_user`(`useEmail`, `useName`, `useSurname`, `fkRole`) VALUES (?, ?, ?, 1)";
        $result_create = $pdo->prepare($sql_create);
        $result_create->bindParam(1, $email);
        $result_create->bindParam(2, $name);
        $result_create->bindParam(3, $surname);
        $result_create->execute();
    }

}

function GetUserID($email)
{
    include "database.php";

    $sql = "SELECT idUser FROM t_user WHERE useEmail = :email";
    $result = $pdo->prepare($sql);
    $result->bindParam(':email', $email);
    $result->execute();

    if ($result->rowCount() > 0) {
        $user = $result->fetch(PDO::FETCH_ASSOC);
        return $user['idUser'];
    }

    return null;
}

function GetUserRole($email)
{
    include "database.php";

    $sql = "SELECT fkRole FROM t_user WHERE useEmail = :email";
    $result = $pdo->prepare($sql);
    $result->bindParam(':email', $email);
    $result->execute();

    if ($result->rowCount() > 0) {
        $user = $result->fetch(PDO::FETCH_ASSOC);
        return $user['fkRole'];
    }

    return null;
}