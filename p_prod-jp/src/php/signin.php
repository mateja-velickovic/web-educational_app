<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte - Journée Pédagogique</title>
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
        <form name="login" action="lib/auth-signin.php" onsubmit="return validation()" method="POST">
            <h2>Création d'un nouveau compte</h2>
            <br>
            <p>Nom d'utilisateur</p>
            <div>
                <input type="text" id="user" name="user" placeholder="Votre nom d'utilisateur..." required>
            </div>

            <p>Mot de passe</p>
            <div>
                <input type="password" id="pass" name="pass" placeholder="Votre mot de passe..." required>
            </div>

            <!-- Si l'utilisateur existe déjà -->
            <?php if (isset($_GET['error']) && $_GET['error'] == "account_exists") { ?>
                <p id="error">Un utilisateur avec ce nom existe déjà.</p>
            <?php } ?>

            <!-- Si la création de compte échoue -->
            <?php if (isset($_GET['error']) && $_GET['error'] == "registration_failed") { ?>
                <p id="error">La création du compte a échoué, veuillez réessayer.</p>
            <?php } ?>

            <input type="submit" id="btn" value="Créer mon compte">
        </form>
    </div>

    <script>
        function validation() {
            var username = document.login.user.value.trim();
            var password = document.login.pass.value.trim();

            if (username === "" || password === "") {
                alert("Veuillez remplir tous les champs avant d'envoyer le formulaire.");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>