<?php
/**
 * @var $real_movie Movie
 * @var $movie_attempt Movie
 */

$title = htmlspecialchars(isset($_SESSION["login"])
    ? $movie_attempt->getTranslatedNameForUser($_SESSION["login"])
    : $movie_attempt->getOriginalName());
$poster_url = $movie_attempt->getPosterUrl();
$backdrop_url = $movie_attempt->getBackdropUrl();

$guess_release_year = substr($movie_attempt->getReleaseDate(), 0, 4); // Date is YYYY-MM-DD
$guess_runtime = $movie_attempt->getRuntime();
$guess_actors = $movie_attempt->getActors();
$guess_directors = $movie_attempt->getDirectors();

$real_release_year = substr($real_movie->getReleaseDate(), 0, 4);
$real_runtime = $real_movie->getRuntime();
$real_actors = $real_movie->getActors();
$real_directors = $real_movie->getDirectors();

$correct_actors = array();
$incorrect_actors = array();
foreach ($guess_actors as $guess_actor) {
    $found = false;
    foreach ($real_actors as $real_actor)
    {
        if ($real_actor->equals($guess_actor))
        {
            $correct_actors[] = $guess_actor;
            $found = true;
            break;
        }
    }
    if (!$found)
        $incorrect_actors[] = $guess_actor;
}


$correct_directors = array();
$incorrect_directors = array();
foreach ($guess_directors as $guess_director) {
    $found = false;
    foreach ($real_directors as $real_director)
    {
        if ($real_director->equals($guess_director))
        {
            $correct_directors[] = $guess_director;
            $found = true;
            break;
        }
    }
    if (!$found)
        $incorrect_directors[] = $guess_director;
}


$hours = floor($guess_runtime/60);
$minutes = $guess_runtime-$hours*60;
if ($hours > 0)
{
    if ($minutes > 9)
        $runtime_text = $hours . "h" . $minutes;
    else
        $runtime_text = $hours . "h0" . $minutes;
}
else
    $runtime_text = $minutes . "min";

$guess_release_year_text = htmlspecialchars($guess_release_year);

$release_year_class = ($real_release_year == $guess_release_year) ? "correct" : "incorrect";
$release_year_arrow = "";
if (intval($real_release_year) > intval($guess_release_year))
{
    $release_year_arrow = '<i class="fa-solid fa-arrow-up"></i>';
}
else if (intval($real_release_year) < intval($guess_release_year))
{
    $release_year_arrow = '<i class="fa-solid fa-arrow-down"></i>';
}

$runtime_class = ($real_runtime == $guess_runtime) ? "correct" : "incorrect";
$runtime_arrow = "";
if ($real_runtime > $guess_runtime)
{
    $runtime_arrow = '<i class="fa-solid fa-arrow-up"></i>';
}
else if ($real_runtime < $guess_runtime)
{
    $runtime_arrow = '<i class="fa-solid fa-arrow-down"></i>';
}

$movie_details_class = ($movie_attempt->getIdMovie() == $real_movie->getIdMovie()) ? "movie-details-correct" : "movie-details";

/** @noinspection CssUnknownTarget */
echo "
<div class='$movie_details_class' style='--background-url: url(\"$backdrop_url\")'>
    <div class='movie-title-card'>
        <div class='movie-poster-container'>
           <img src='$poster_url' alt='poster'>
        </div>
        <span>$title</span>
    </div>
    <div class='movie-info'>
        <div class='movie-info-part $release_year_class'>
            <span>Année de sortie : </span>
            <span>$guess_release_year_text $release_year_arrow</span>
        </div>
        <div class='movie-info-part $runtime_class'>
            <span>Durée du film : </span>
            <span>$runtime_text $runtime_arrow</span>
        </div>
        <div class='movie-people-list'>
            <span>Réalisation :</span>
            <ul class='movie-people-list-items'>";
foreach ($correct_directors as $director)
{
    $dir_param = urlencode($director->getIdDirector());
    $dir_name = htmlspecialchars($director->getFullName());
    $dir_url = $director->getPictureUrl();
    echo "
                <li class='movie-people-item correct'>
                    <img src='$dir_url' alt='picture'>
                    <span>$dir_name</span>
                </li>
            ";
}
foreach ($incorrect_directors as $director)
{
    $dir_param = urlencode($director->getIdDirector());
    $dir_name = htmlspecialchars($director->getFullName());
    $dir_url = $director->getPictureUrl();
    echo "
                <li class='movie-people-item incorrect'>
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
foreach ($correct_actors as $actor)
{
    $act_param = urlencode($actor->getIdActor());
    $act_name = htmlspecialchars($actor->getFullName());
    $act_url = $actor->getPictureUrl();
    echo "
                <li class='movie-people-item correct'>
                    <img src='$act_url' alt='picture'>
                    <span>$act_name</span>
                </li>
                        ";
}
foreach ($incorrect_actors as $actor)
{
    $act_param = urlencode($actor->getIdActor());
    $act_name = htmlspecialchars($actor->getFullName());
    $act_url = $actor->getPictureUrl();
    echo "
                <li class='movie-people-item incorrect'>
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