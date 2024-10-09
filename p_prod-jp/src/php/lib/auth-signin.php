<?php
session_start();
require "config.php";
include "database.php";

// Récupération du nom d'utilisateur et mot de passe
$username = trim($_POST['user']);
$password = trim($_POST['pass']);

// Rechercher si l'utilisateur n'existe pas
$sql = "SELECT * FROM t_user WHERE useUsername = :username";
$result = $pdo->prepare($sql);
$result->bindParam(':username', $username);
$result->execute();

if ($result->rowCount() == 0) {
    $sql_create = "INSERT INTO `t_user`(`useUsername`, `usePassword`, `fkRole`) VALUES (?, ?, 1)";
    $result_create = $pdo->prepare($sql_create);

    $c_password = password_hash($password, PASSWORD_DEFAULT);

    if ($result_create->execute([$username, $c_password])) {
        header("Location: ../login.php?success=account_created");
        exit();
    } else {
        header("Location: ../signin.php?error=registration_failed");
        exit();
    }
} else {
    header("Location: ../signin.php?error=account_exists");
    exit();
}
