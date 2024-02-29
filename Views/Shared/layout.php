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
            <a href="/">Home</a>
            <a href="/movie/">Movies</a>
        </nav>
    </header>
    <main>
        <?php require_once $view_name ?>
    </main>
    <footer>Réalisé dans le cadre du cours de Développement web au 4e semestre du CNAM IEM</footer>
</body>
</html>