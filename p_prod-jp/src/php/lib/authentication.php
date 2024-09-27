<?php
session_start();

require "../config.php";
include "database.php";

$username = $_POST['user'];
$password = $_POST['pass'];

$sql = "SELECT * FROM t_user WHERE useNom = :username AND usePassword = :password";

$result = $pdo->prepare($sql);

// Prévention des injections SQL avec les paramètres préparés
$result->bindParam(':username', $username);
$result->bindParam(':password', $password);

$result->execute();

if ($result->rowCount() > 0) {
    $user = $result->fetch();

    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $user['useNom'];
    $_SESSION['userid'] = $user['idUser'];

    header("Location: ../../../index.php");
    exit();
} else {
    header("Location: ../login.php");
    echo "<script>alert('asdads');</script>";
}
