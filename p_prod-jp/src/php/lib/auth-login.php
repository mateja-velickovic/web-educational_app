<?php
session_start();

require "../config.php";
include "database.php";

$username = $_POST['user'];
$password = $_POST['pass'];

// Requête pour vérifier qu'un utilisateur existe à ce nom (nom unique)
$sql = "SELECT * FROM t_user WHERE useUsername = :username";
$result = $pdo->prepare($sql);
$result->bindParam(':username', $username);
$result->execute();

if ($result->rowCount() > 0) {
    $user = $result->fetch();

    // Le
    if (password_verify($password, $user['usePassword'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user['useUsername'];
        $_SESSION['userid'] = $user['idUser'];

        header("Location: ../../../index.php");
        exit();
    } else {
        header("Location: ../login.php?error=incorrect_password");
        exit();
    }
} else {
    header("Location: ../login.php?error=incorrect_password");
    exit();
}
