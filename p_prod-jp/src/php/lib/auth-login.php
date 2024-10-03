<?php
session_start();

require "../config.php";
include "database.php";

$username = $_POST['user'];
$password = $_POST['pass'];

$sql = "SELECT * FROM t_user WHERE useUsername = :username AND usePassword = :password";

$result = $pdo->prepare($sql);

$hash = password_hash($password, PASSWORD_DEFAULT);

// Prévention des injections SQL avec les paramètres préparés
$result->bindParam(':username', $username);
$result->bindParam(':password', $hash);

$result->execute();

if ($result->rowCount() > 0) {
    // if (password_verify($password, $hash)) {
    $user = $result->fetch();

    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $user['useUsername'];
    $_SESSION['userid'] = $user['idUser'];

    header("Location: ../../../index.php");
} else {
    header("Location: ../login.php");
}
