<div>
    <?php
        if((new UserMovieHistory())->getHistoryMoviesByDate($_SESSION['login'], date('Y-m-d'))){
            echo '<div class="custom-input">
                <label for="movie-search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </label>
                <input placeholder="Chercher un film" type="search" id="movie-search-bar">
            </div>

            <ul class="movie-list transparent game-list" id="movie-list-ajax">
            </ul>';
        }
        else {
            echo "<h2 style='color: red;'>Tu as déjà trouvé le sussy movie d'aujourd'hui. Revien demain pour un nouveau sussy movie !</h2>";
        }
    ?>
</div>

<div id="game-attempts">
<?php
if(!empty($_SESSION['guessed_movies'])){
    foreach($_SESSION['guessed_movies'] as $movie_serialize){
        $movie_data = unserialize($movie_serialize);
        $movie_attempt = Movie::deserializeData($movie_data);
        $id_real_movie = (new Movie())->randomMovie();
        $real_movie = (new Movie())->get($id_real_movie);
        echo '<div>';
        require "Views/Game/attempt.php";
        echo '</div>';
    }
}
?>
</div>
<script src="/Resources/scripts/game.js"></script>