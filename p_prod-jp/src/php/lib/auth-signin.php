<?php
session_start();

require "../config.php";
include "database.php";

$username = $_POST['user'];
$password = $_POST['pass'];

$sql = "SELECT * FROM t_user WHERE useUsername = :username AND usePassword = :password";

$result = $pdo->prepare($sql);

// Prévention des injections SQL avec les paramètres préparés
$result->bindParam(':username', $username);
$result->bindParam(':password', $password);

$result->execute();

if ($result->rowCount() == 0) {
    $sql_create = "INSERT INTO `t_user`(`useUsername`, `usePassword`, `fkRole`) VALUES (?,?,1)";

    $result_create = $pdo->prepare($sql_create);
    $c_password = password_hash($password, PASSWORD_DEFAULT);
    $result_create->execute([$username, $c_password]);

    header("Location: ../login.php");
} else {
    header("Location: ../signin.php");
}
