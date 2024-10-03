<?php
function getInscriptionsCount($pdo, $idActivite)
{
    $sql = "SELECT COUNT(*) AS insc FROM t_registration WHERE fkActivity = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $idActivite, PDO::PARAM_INT);
    $stmt->execute();

    $count = $stmt->fetch(PDO::FETCH_ASSOC);

    return $count['insc'];
}

function hasUserJoined($pdo, $idUser)
{

}
?>