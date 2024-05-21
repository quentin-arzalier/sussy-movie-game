<?php
/**
 * @var UserMovieHistory $active_history
 * @var array<UserMovieHistory> $histories
 * @var int $curr_page
 * @var int $max_page
 * @var int $page_size
 * @var int $total_histories
 */
$attempt_count = $active_history->getAttemptCount() ;
$date_of_success = $active_history->getDateOfSuccess();
$id_movie = $active_history->getIdMovie();
$id_param = urlencode($id_movie);
$title = htmlspecialchars($active_history->getOriginalName()); // TODO : Langue utilisateur
$poster_url = $active_history->getPosterUrl();
$backdrop_url = $active_history->getBackdropUrl();
$release_date = htmlspecialchars($active_history->getReleaseDate());
$runtime = htmlspecialchars($active_history->getRuntime());
$actors = $active_history->getActors();
$directors = $active_history->getDirectors();

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


<div class="content-with-side-nav">
    <div>
        <ul>
            <?php
            foreach ($histories as $history)
            {
                $date_display = htmlspecialchars($history->getDateOfSuccess());
                $attempts = $history->getAttemptCount();
                $date_param = urlencode($history->getDateOfSuccess());

                if ($active_history->getDateOfSuccess() == $history->getDateOfSuccess())
                {
                    echo "<li>$date_display - $attempts essai(s)</li>";
                }
                else {
                    echo "<li><a href='/user/history?date=$date_param&page=$curr_page'>$date_display - $attempts essai(s)</a></li>";
                }
            }
            ?>
        </ul>
        <div class="list-nav">
            <?php
            $active_date_param = urlencode($active_history->getDateOfSuccess());
            $previous_page = $curr_page - 1;
            $next_page = $curr_page + 1;
            if ($previous_page > 0)
                echo "<a href='/user/history?date=$active_date_param&page=$previous_page'><button><i class='fa-solid fa-arrow-left'></i></button></a>";
            else
                echo "<button disabled><i class='fa-solid fa-arrow-left'></i></button>";

            $first_nb = $page_size * ($curr_page - 1) + 1;
            $last_nb = $first_nb + count($histories) - 1   ;

            echo "<span>Historiques $first_nb à $last_nb sur $total_histories</span>";

            if ($next_page <= $max_page)
                echo "<a href='/user/history?date=$active_date_param&page=$next_page'><button><i class='fa-solid fa-arrow-right'></i></button></a>";
            else
                echo "<button disabled><i class='fa-solid fa-arrow-right'></i></button>";
            ?>
        </div>
    </div>

<?php
        /** @noinspection CssUnknownTarget */
        echo "
    <div class='movie-details' style='--background-url: url(\"$backdrop_url\")'>
        <div class='movie-find'>
            <span>Trouvé le $date_of_success</span>
            <span>En $attempt_count coups</span>
        </div>
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
