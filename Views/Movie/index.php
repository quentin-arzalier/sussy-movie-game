<?php
foreach ($movies as $movie)
{
    usleep(500);
    $id_movie = $movie->getIdMovie();
    $id_param = urlencode($id_movie);
    $title = htmlspecialchars($movie->getOriginalName()); // TODO : Langue utilisateur
    $poster_url = $movie->getPosterUrl();
    $backdrop_url = $movie->getBackdropUrl();
    $release_date = htmlspecialchars($movie->getReleaseDate());
    $runtime = htmlspecialchars($movie->getRuntime());
    $actors = $movie->getActors();
    $directors = $movie->getDirectors();

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
}