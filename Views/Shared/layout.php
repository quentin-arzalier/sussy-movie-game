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
    <meta name="description" content="Un site de devinettes avec un nouveau film à trouver chaque jour!">
    <link rel="stylesheet" href="/resources/styles/styles.css">
    <link rel="stylesheet" href="/resources/styles/forms.css">
    <link rel="stylesheet" href="/resources/styles/spinner.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://kit.fontawesome.com/fcd7e17e10.js" crossorigin="anonymous"></script>
    <title>Sussy Movie Game</title>
</head>
<body>
    <header>
        <h1 class="main-title">The Sussy <br> Movie Game</h1>
        <nav>
            <a href="/" title="home"><i class="fa-solid fa-house"></i></a>
            <?=(isset($_SESSION["login"]))
            ? "
            <a href='/user/account' title='compte'><i class='fa-solid fa-user'></i></a>
            <a href='/user/history' title='historique'><i class='fa-solid fa-list'></i></a>
            " : "
            <a href='/user' title='connexion'><i class='fa-solid fa-right-to-bracket'></i></a>
            " 
            ?>
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
        <div class='container account-container'>
            <span>Bonjour $_SESSION[login]!</span>
            <div>
                <a href='/user/account' title='profil'>Profil</a>
                |
                <a href='/user/logout' title='déconnexion'>Déconnexion</a>
            </div>
            $admin_span
        </div>
            ";
        }
        else {
            echo "
        <div class='container account-container'>
            <a href='/user/' title='connexion'>Connexion</a>
            <hr>
            <a href='/user/createpage' title='création de compte'>Créer un compte</a>
        </div>
            ";
        }
        ?>
    </header>
    <main>
        <div id="sussy-spinner" style="display: none;">
            <div></div>
            <div>
                <span>Chargement </span>
                <span>.</span>
                <span>.</span>
                <span>.</span>
            </div>
        </div>
        <script src="/resources/scripts/custom_alert.js"></script>

        <?php require_once $view_name ?>

        <button id="how-to-play-button" title="Comment jouer?">
            <i class="fa-solid fa-circle-info"></i>
        </button>
        <section id="how-to-play-section" style="display: none">
            <div>
                <h2>The Sussy Movie Game</h2>
                <button class="close-button">
                    <i class="fa-solid fa-times"></i>
                </button>
                <hr>
                <h3>Qu'est-ce que c'est</h3>
                <p>
                    The sussy movie game est un jeu de devinettes dans lequel vous devrez deviner un nouveau film chaque jour.
                    Le film vient de la liste des films les plus populaires de The Movie Database : <a href="https://www.themoviedb.org/movie/top-rated">Voir la liste ici</a>
                </p>
                <hr>
                <h3>Comment jouer</h3>
                <p>
                    Une fois connecté, une barre de recherche apparaît sur la page d'accueil de l'application.
                    Cherchez seulement un film dans notre liste et cliquez sur votre choix pour obtenir un récapitulatif.
                </p>
                <img src="/resources/img/tutorial.png" alt="tutorial-screenshot" width="500">
                <p>
                    Basez vous sur les informations pour trouver le film du jour!
                </p>
                <h3>Bonne chance!</h3>
            </div>
        </section>

        <script src="/resources/scripts/how_to_play.js"></script>
    </main>
    <script>
        <?php
        if (isset($_SESSION["message"]))
        {
            echo "customAlert(`$_SESSION[message]`, false);";
            unset($_SESSION["message"]);
        }
        if (isset($_SESSION["errorMessage"]))
        {
            echo "customAlert(`$_SESSION[errorMessage]`, true);";
            unset($_SESSION["errorMessage"]);
        }
        ?>

    </script>
    <footer>Réalisé dans le cadre du cours de Développement web au 4e semestre du CNAM IEM</footer>
</body>
</html>