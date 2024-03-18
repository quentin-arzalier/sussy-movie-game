<?php
class MovieController {
    public static function searchMoviesInDatabase(): void
    {
        if (!isset($_GET["search"]))
            return;

        $search = $_GET["search"];

        $movies = Movie::GetMoviesByName($search);

        echo "[";

        $i = 0;
        $movie_count = count($movies);
        foreach ($movies as $movie) {
            $id = $movie->getIdMovie();
            $poster = $movie->getPosterPath();
            $title = $movie->getOriginalName();
            $potentialComma = ($i == $movie_count - 1) ? "" : ",";
            echo "
            {
                \"id\": $id,
                \"title\": \"$title\",
                \"poster_path\": \"$poster\"
            }$potentialComma
            ";
            $i++;
        }


        echo "]";
    }
}