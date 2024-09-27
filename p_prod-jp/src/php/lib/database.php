<?php

$host = "db";
$port = "3306";
$db = "db_jpprod";
$user = "root";
$password = "root";

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {

    $actQuery = "SELECT * FROM t_activite";
    $getActivities = $pdo->prepare($actQuery);
    $getActivities->execute();
    $result = $getActivities->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit(); 
}
?>