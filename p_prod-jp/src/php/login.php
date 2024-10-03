<html>

<head>
    <title>Connexion - Journée Pédagogique</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../../resources/css/style.css" />
</head>

<body>
    <header>
        <p id="t1">ETML - Journée Pédagogique</p>
        <p id="info">Bienvenue sur le site de la Journée Pédagogique de l'ETML. Connectez-vous pour avoir accès au reste
            du
            site.
        <p>
        </p>
        <div class="log">
            <a class="acc" href="../../../index.php">REVENIR À L'ACCUEIL</a>
        </div>
    </header>

    <div id="form">
        <form name="login" action="lib/auth-login.php" onsubmit="return validation()" method="POST">
            <p>
            <p>Nom d'utilisateur</p>
            <input type="text" id="user" name="user" placeholder="Votre nom d'utilisateur..." />
            </p>
            <p>
            <p>Mot de passe</p>
            <input type="password" id="pass" name="pass" placeholder="Votre mot de passe..." />

            <?php if ($_GET['error'] == "incorrect_password") { ?>
                <p id="incorrect_password">Identifiants incorrects</p>
            <?php } ?>

            </p>

            <input type="submit" id="btn" value="Connexion" /><br>
            <a href="signin.php">Créer un compte</a>


    </div>
    </form>
    </div>
    <script>
        function validation() {
            var id = document.login.user.value;
            var ps = document.login.pass.value;
            if (id.length == "" && ps.length == "") {
                alert("Veuillez remplir les champs avant d'envoyer le formulaire.")
                return false;
            }
            else {
                if (id.length == "") {
                    alert("Veuillez saisir un nom d'utilisateur.");
                    return false;
                }
                if (ps.length == "") {
                    alert("Veuillez saisir un mot de passe.");
                    return false;
                }
            }
        }  
    </script>
</body>

</html>