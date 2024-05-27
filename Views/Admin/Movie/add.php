<?php
/**
 * @var array<Movie> $movies
 */
?>

<h2>Ajouter un film</h2>

<div class="custom-input">
    <label for="movie-search-bar">
        <i class="fa-solid fa-magnifying-glass"></i>
    </label>
    <input placeholder="Ajouter un film" type="search" id="movie-search-bar">
</div>

<ul class="movie-list transparent" id="movie-list-ajax">
</ul>


<script src="/resources/scripts/admin_movie_list.js"></script>
<script>
    movieIdsInDatabase = [
        <?php
            foreach ($movies as $movie)
                echo $movie->getIdMovie() . ','
        ?>
    ];
</script>
