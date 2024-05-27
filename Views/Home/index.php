<div>
    <?php
        if((new UserMovieHistory())->getHistoryMoviesByDate($_SESSION['login'], date('Y-m-d'))){
            echo '<div class="custom-input">
                <label for="movie-search-bar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </label>
                <input placeholder="Chercher un film" type="search" id="movie-search-bar">
            </div>

            <ul class="movie-list transparent" id="movie-list-ajax">
            </ul>
            <h2 id="success-message" style="color: green;"></h2>
            <h3 id="timer"></h3>';
        }
        else {
            echo '<h2 id="success-message" style="color: red;">Tu as déjà trouvé le sussy movie d\'aujourd\'hui. Reviens demain pour un nouveau sussy movie !</h2>
            <h3 id="timer"></h3>';
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
<script src="/resources/scripts/game.js"></script>