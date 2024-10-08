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
        <form name="login" action="lib/auth-signin.php" onsubmit="return validation()" method="POST">
            <h2>Création d'un nouveau compte</h2><br>
            <p>
            <p>Nom d'utilisateur</p>
            <input type="text" id="user" name="user" placeholder="Votre nom d'utilisateur..." />
            </p>
            <p>
            <p>Mot de passe</p>
            <input type="password" id="pass" name="pass" placeholder="Votre mot de passe..." />
            </p>

            <!-- Si l'utilisateur existe déjà -->
            <?php if (isset($_GET['error']) && $_GET['error'] == "account_exists") { ?>
                <p id="error">Un utilisateur à ce nom existe déjà.</p>
            <?php } ?>

            <!-- Si la création de compte échoue -->
            <?php if (isset($_GET['error']) && $_GET['error'] == "registration_failed") { ?>
                <p id="error">Création du compte non-réussie, veuillez réessayer.</p>
            <?php } ?>

            <input type="submit" id="btn" value="Créer mon compte" />
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