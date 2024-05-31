<?php

class ApiController
{
    public static function getNewMoviesFromAPI()
    {
        if($_SERVER["REQUEST_METHOD"] != "GET") {
            http_response_code(404);
            return;
        }
        $name = $_GET["name"];
        $nameParam = urlencode($name);
        $api_url = "https://api.themoviedb.org/3/search/movie?query=$nameParam&page=1&api_key=" . API_KEY;
        echo file_get_contents($api_url);
    }

    public static function addMovieToDatabase(): bool
    {
        if($_SERVER["REQUEST_METHOD"] != "POST") {
            http_response_code(404);
            return false;
        }

        $movie_id = $_POST["movie_id"];

        return self::addMovieWithTmdbId($movie_id);
    }

    public static function addPopularMovies(): void
    {
        if($_SERVER["REQUEST_METHOD"] != "POST") {
            http_response_code(404);
            return;
        }

        $iteration_count = 1;
        $added_movie_count = 0;

        while ($added_movie_count == 0)
        {
            $popular_url = "https://api.themoviedb.org/3/movie/top_rated?language=en-US&page=$iteration_count&api_key=" . API_KEY;
            $popular_json = file_get_contents_utf8($popular_url);
            $popular_obj = json_decode($popular_json, true);

            // results n'est pas dans la liste quand on dépasse la pagination.
            if (!isset($popular_obj["results"]))
            {
                http_response_code(204); // Already exists => no content
                echo 0;
                return;
            }

            foreach ($popular_obj["results"] as $movie) {
                if (self::addMovieWithTmdbId($movie["id"])){
                    $added_movie_count++;
                }
            }
            $iteration_count++;
        }

        http_response_code(201); // Created
        echo $added_movie_count;
    }



    private static function addMovieWithTmdbId($movie_id): bool
    {
        if ((new Movie())->get($movie_id) != null)
        {
            http_response_code(409); // Already exists => conflict
            return false;
        }

        $id_param = urlencode($movie_id);
        $details_url = "https://api.themoviedb.org/3/movie/$id_param?api_key=" . API_KEY;
        $titles_url = "https://api.themoviedb.org/3/movie/$id_param/alternative_titles?api_key=" . API_KEY;
        $credits_url = "https://api.themoviedb.org/3/movie/$id_param/credits?api_key=" . API_KEY;

        $details_json = file_get_contents_utf8($details_url);
        $details_obj = json_decode($details_json, true);


        $mov = Movie::CreateMovie(
            $details_obj["id"],
            $details_obj["original_title"],
            $details_obj["release_date"],
            $details_obj["runtime"],
            $details_obj["backdrop_path"],
            $details_obj["poster_path"],
        );

        try {
            if ($mov->save()){
                foreach ($details_obj["genres"] as $genre) {
                    if (!$mov->addGenre($genre["id"]))
                    {
                        http_response_code(500);
                        $mov->delete();
                        return false;
                    }
                }

                $titles_json = file_get_contents_utf8($titles_url);
                $titles_obj = json_decode($titles_json, true);
                $countries = array();
                $movie_names = array();
                foreach ($titles_obj["titles"] as $title_obj)
                {
                    // Précaution pour éviter d'avoir des pays en double. On veut un seul titre par pays.
                    if ($title_obj["type"] != "" || $title_obj["type"] != null || in_array($title_obj["iso_3166_1"], $countries))
                        continue;

                    $movname = MovieName::CreateMovieName($mov->getIdMovie(), $title_obj["iso_3166_1"], $title_obj["title"]);
                    $countries[] = $title_obj["iso_3166_1"];
                    $movie_names[] = $movname;
                }
                if (!MovieName::SaveManyMovieNames($movie_names))
                {
                    http_response_code(500);
                    $mov->delete();
                    return false;
                }

                $credits_json = file_get_contents_utf8($credits_url);
                $credits_obj = json_decode($credits_json, true);

                $actor_query_obj = new Actor();
                $actors = array();
                foreach ($credits_obj["cast"] as $api_actor)
                {
                    // Pour éviter la duplication acteur/film si jamais le film crédite plusieurs fois le même acteur
                    if (in_array($api_actor["id"], $actors))
                        continue;

                    $actor = $actor_query_obj->get($api_actor["id"]);
                    if ($actor == null)
                    {
                        $actor = Actor::CreateActor($api_actor["id"], $api_actor["name"], $api_actor["profile_path"]);
                        if (!$actor->save())
                        {
                            http_response_code(500);
                            $mov->delete();
                            return false;
                        }
                    }
                    $actors[] = $api_actor["id"];
                }
                if (!$mov->addManyActors($actors))
                {
                    http_response_code(500);
                    $mov->delete();
                    return false;
                }

                $director_query_obj = new Director();
                $directors = array();
                foreach ($credits_obj["crew"] as $api_crew) {
                    if (strtolower($api_crew["job"]) != "director")
                        continue;
                    $director = $director_query_obj->get($api_crew["id"]);
                    if ($director == null)
                    {
                        $director = Director::CreateDirector($api_crew["id"], $api_crew["name"], $api_crew["profile_path"]);
                        if (!$director->save())
                        {
                            http_response_code(500);
                            $mov->delete();
                            return false;
                        }
                    }
                    $directors[] = $api_crew["id"];
                }
                if (!$mov->addManyDirectors($directors))
                {
                    http_response_code(500);
                    $mov->delete();
                    return false;
                }

            }
        }
        catch (Exception $e)
        {
            http_response_code(500);
            $mov->delete();
            return false;
        }
        return true;
    }

    public static function addAllNewGenres()
    {
        $newGenreCount = 0;
        $api_url = "https://api.themoviedb.org/3/genre/movie/list?api_key=" . API_KEY;
        $json = file_get_contents($api_url);
        $obj = json_decode($json, true);
        $api_genres = $obj["genres"];

        foreach ($api_genres as $api_genre) {
            $genre = Genre::CreateGenre($api_genre["id"], $api_genre["name"]);
            if ($genre->save())
                $newGenreCount++;
        }
        return $newGenreCount;
    }
}