<?php
/**
 * @var Movie $active_movie
 * @var array<Movie> $movies
 * @var int $curr_page
 * @var int $max_page
 * @var int $page_size
 * @var int $total_movies
 */
?>

<div class="content-with-side-nav">
    <?php
    $id_movie = $active_movie->getIdMovie();
    $id_param = urlencode($id_movie);
    $title = htmlspecialchars($active_movie->getOriginalName()); // TODO : Langue utilisateur
    $poster_url = $active_movie->getPosterUrl();
    $backdrop_url = $active_movie->getBackdropUrl();
    $release_date = htmlspecialchars($active_movie->getReleaseDate());
    $runtime = htmlspecialchars($active_movie->getRuntime());
    $actors = $active_movie->getActors();
    $directors = $active_movie->getDirectors();

    $hours = floor($runtime/60);
    $minutes = $runtime-$hours*60;
    if ($hours > 0)
    {
        if ($minutes > 9)
            $runtime_text = $hours . "h" . $minutes;
        else
            $runtime_text = $hours . "h0" . $minutes;
    }
    else
        $runtime_text = $minutes . "min";

    ?>

    <div>
        <ul>
            <?php
            foreach ($movies as $movie)
            {
                $movie_name = $movie->getOriginalName();
                $movie_id = $movie->getIdMovie();
                if ($active_movie->getIdMovie() == $movie_id)
                {
                    echo "<li>$movie_name</li>";
                }
                else {
                    echo "<li><a href='/admin/movie?id_movie=$movie_id&page=$curr_page'>$movie_name</a></li>";
                }
            }
            ?>
        </ul>
        <div class="list-nav">
            <?php
                $active_id = $active_movie->getIdMovie();
                $previous_page = $curr_page - 1;
                $next_page = $curr_page + 1;
                if ($previous_page > 0)
                    echo "<a href='/admin/movie?id_movie=$active_id&page=$previous_page'><button><i class='fa-solid fa-arrow-left'></i></button></a>";
                else
                    echo "<button disabled><i class='fa-solid fa-arrow-left'></i></button>";

                $first_nb = $page_size * ($curr_page - 1) + 1;
                $last_nb = $first_nb + count($movies) - 1   ;

                echo "<span>Films $first_nb à $last_nb sur $total_movies</span>";

                if ($next_page <= $max_page)
                    echo "<a href='/admin/movie?id_movie=$active_id&page=$next_page'><button><i class='fa-solid fa-arrow-right'></i></button></a>";
                else
                    echo "<button disabled><i class='fa-solid fa-arrow-right'></i></button>";
            ?>
        </div>
    </div>


    <?php
    /** @noinspection CssUnknownTarget */
    echo "
    <div class='movie-details' style='--background-url: url(\"$backdrop_url\")'>
        <div class='movie-title-card'>
            <div class='movie-poster-container'>
               <img src='$poster_url' alt='poster'>
            </div>
            <span>$title</span>
        </div>
        <div class='movie-info'>
            <div class='movie-info-part'>
                <span>Date de sortie : </span>
                <span>$release_date</span>
            </div>
            <div class='movie-info-part'>
                <span>Durée du film : </span>
                <span>$runtime_text</span>
            </div>
            <div class='movie-people-list'>
                <span>Réalisation :</span>
                <ul class='movie-people-list-items'>";
            foreach ($directors as $director)
            {
                $dir_param = urlencode($director->getIdDirector());
                $dir_name = htmlspecialchars($director->getFullName());
                $dir_url = $director->getPictureUrl();
                echo "
                    <li class='movie-people-item'>
                        <img src='$dir_url' alt='picture'>
                        <span>$dir_name</span>
                    </li>
                ";
            }

            echo "
                </ul>
            </div>
        </div>
        <div class='movie-actors'>
            <div class='movie-people-list'>
                <span>Casting :</span>
                <ul class='movie-people-list-items'>";
                    foreach ($actors as $actor)
                    {
                        $act_param = urlencode($actor->getIdActor());
                        $act_name = htmlspecialchars($actor->getFullName());
                        $act_url = $actor->getPictureUrl();
                        echo "
                    <li class='movie-people-item'>
                        <img src='$act_url' alt='picture'>
                        <span>$act_name</span>
                    </li>
                            ";
                    }
                    echo "
                </ul>
            </div>
        </div>
    </div>    
    ";
    ?>
</div>