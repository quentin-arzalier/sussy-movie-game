<?php
/**
 * @var string $view_name
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Resources/styles/styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://kit.fontawesome.com/fcd7e17e10.js" crossorigin="anonymous"></script>
    <title>Sussy Movie Game</title>
</head>
<body>
    <header>
        <h1 class="main-title">The Sussy Movie Game</h1>
        <nav>
            <a href="/">Accueil</a>
        </nav>
        <?php
        if (key_exists("login", $_SESSION) && $_SESSION["login"] != "")
        {
            $admin_span = "";
            if (key_exists("is_admin", $_SESSION) && $_SESSION["is_admin"])
            {
                $admin_span = "<span><a href='/admin'>Portail administrateur</a></span>";
            }
            echo "
        <div class='account-container'>
            <span>Bonjour $_SESSION[login]!</span>
            <div>
                <a href='/user/account'>Profil</a>
                |
                <a href='/user/logout'>Déconnexion</a>
            </div>
            $admin_span
        </div>
            ";
        }
        else {
            echo "
        <div class='account-container'>
            <a href='/user/'>Connexion</a>
            <a href='/user/createpage'>Créer un compte</a>
        </div>
            ";
        }
        ?>
    </header>
    <main>
        <?php require_once $view_name ?>
    </main>
    <footer>Réalisé dans le cadre du cours de Développement web au 4e semestre du CNAM IEM</footer>
</body>
</html>