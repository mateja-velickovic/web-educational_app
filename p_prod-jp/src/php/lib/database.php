<?php

$host = "pprod-db.mysql.database.azure.com";
$port = "3306";
$db = "db_jpprod";
$user = "matvelickov";
$password = getenv('DB_PASSWORD');

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=UTF8";

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $actQuery = "SELECT * FROM t_activity";
    $getactivities = $pdo->prepare($actQuery);
    $getactivities->execute();
    $result = $getactivities->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}
?>