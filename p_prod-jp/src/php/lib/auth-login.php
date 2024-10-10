<?php
session_start();
require "config.php";
include "database.php";

// Récupération du nom d'utilisateur et mot de passe
$username = trim($_POST['user']);
$password = trim($_POST['pass']);

// Rechercher si l'utilisateur existe
$sql = "SELECT * FROM t_user WHERE useUsername = :username";
$result = $pdo->prepare($sql);
$result->bindParam(':username', $username);
$result->execute();

if ($result->rowCount() > 0) {
    $user = $result->fetch();

    if (password_verify($password, $user['usePassword'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['useUsername'];
        $_SESSION['userid'] = $user['idUser'];
        $_SESSION['userrole'] = $user['fkRole'];

        header("Location: ../../../index.php");
        exit();
    } else {
        header("Location: ../login.php?error=incorrect_password");
        exit();
    }
} else {
    header("Location: ../login.php?error=user_not_found");
    exit();
}
