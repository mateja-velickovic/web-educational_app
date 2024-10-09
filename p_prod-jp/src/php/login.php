<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Journée Pédagogique</title>
    <link rel="stylesheet" href="../../../resources/css/style.css">
</head>

<body>
    <header>
        <h1 id="t1">ETML - Journée Pédagogique <?php echo date("Y") ?></h1>
        <div class="log">
            <a class="acc" href="../../../index.php">REVENIR À LA PAGE D'ACCUEIL</a>
        </div>
    </header>

    <div id="form">
        <form name="login" action="lib/auth-login.php" onsubmit="return validation()" method="POST">

            <p>Nom d'utilisateur</p>
            <div>
                <input type="text" id="user" name="user" placeholder="Votre nom d'utilisateur..." required>
            </div>

            <p>Mot de passe</p>
            <div>
                <input type="password" id="pass" name="pass" placeholder="Votre mot de passe..." required>
            </div>

            <!-- Gestion des erreurs et messages -->
            <?php if (isset($_GET['error']) && $_GET['error'] == "incorrect_password") { ?>
                <p id="error">Identifiants incorrects.</p>
            <?php } ?>

            <?php if (isset($_GET['error']) && $_GET['error'] == "user_not_found") { ?>
                <p id="error">Utilisateur inexistant.</p>
            <?php } ?>

            <?php if (isset($_GET['success']) && $_GET['success'] == "account_created") { ?>
                <p id="success">Compte créé avec succès. Connectez-vous.</p>
            <?php } ?>

            <input type="submit" id="btn" value="Connexion">
            <p><a href="signin.php">Créer un compte</a></p>
        </form>
    </div>
</body>

</html>