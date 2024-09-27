<?php

include "config.php";
include "lib/database.php";


$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_POST['id'] == null) {
    // Redirect the user if id is null
    header('Location: ../../../index.php');
} else {

    if (isset($pdo)) {
        $getActQuery = "SELECT * FROM t_activite WHERE idActivite = '$_POST[id]'";
        $getAct = $pdo->prepare($getActQuery);
        $getAct->execute();
        $actResult = $getAct->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Connecteur PDO non-trouvé.";
    }

    foreach ($actResult as $a) {
        ?>
        <p>Vous avez chosi <?php echo $a['actLibelle'] ?> qui aura lieu le <?php echo $a['actDate'] ?> à
            <?php echo $a['actLieu'] ?>.
        </p>
        <?php
    }

}
