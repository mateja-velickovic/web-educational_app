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

function hasUserJoined($pdo, $idActivity, $idUser)
{
    $sql = "SELECT COUNT(*) AS id FROM t_registration WHERE fkUser = :id AND fkActivity = :activity";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $idUser, PDO::PARAM_INT);
    $stmt->bindParam(':activity', $idActivity, PDO::PARAM_INT);
    $stmt->execute();

    $id = $stmt->fetch(PDO::FETCH_ASSOC);

    return $id['id'];
}