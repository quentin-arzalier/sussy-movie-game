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
    <link rel="stylesheet" href="/Resources/styles/admin.css">
    <link rel="stylesheet" href="/Resources/styles/spinner.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://kit.fontawesome.com/fcd7e17e10.js" crossorigin="anonymous"></script>
    <title>Sussy Movie Game - Admin</title>
</head>
<body class="admin-portal">
<header>
    <h1 class="main-title">The Sussy Movie Game</h1>
    <nav>
        <a href="../../../index.php">Accueil</a>
        <a href="/admin/movie">Gérer les films</a>
        <a href="/admin/movie/add">Ajouter un film</a>
        <a href="/admin/user">Gérer les utilisateurs</a>
    </nav>
    <div class="container account-container">
        <span>Portail administrateur</span>
        <a href="/">Retour au portail utilisateur</a>
    </div>
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

    <?php require_once $view_name ?>
</main>
<footer>Réalisé dans le cadre du cours de Développement web au 4e semestre du CNAM IEM</footer>
</body>
</html>