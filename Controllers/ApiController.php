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
        $id_param = urlencode($movie_id);
        $details_url = "https://api.themoviedb.org/3/movie/$id_param?api_key=" . API_KEY;
        $titles_url = "https://api.themoviedb.org/3/movie/$id_param/alternative_titles?api_key=" . API_KEY;
        $credits_url = "https://api.themoviedb.org/3/movie/$id_param/credits?api_key=" . API_KEY;

        $details_json = file_get_contents_utf8($details_url);
        $details_obj = json_decode($details_json, true);

        $mov = Movie::CreateMovie(
            $details_obj["id"],
            $details_obj["original_language"],
            $details_obj["release_date"],
            $details_obj["runtime"]
        );
        if ($mov->save()){
            foreach ($details_obj["genres"] as $genre) {
                if (!$mov->addGenre($genre["id"]))
                {
                    http_response_code(500);
                    echo "Error encountered while adding genre $genre[name] to movie $movie_id";
                    $mov->delete();
                    return false;
                }
            }

            $titles_json = file_get_contents_utf8($titles_url);
            $titles_obj = json_decode($titles_json, true);
            $countries = array();
            foreach ($titles_obj["titles"] as $title_obj)
            {
                // Précaution pour éviter d'avoir des pays en double. On veut un seul titre par pays.
                if ($title_obj["type"] != "" || $title_obj["type"] != null || in_array($title_obj["iso_3166_1"], $countries))
                    continue;

                $movname = MovieName::CreateMovieName($mov->getIdMovie(), $title_obj["iso_3166_1"], $title_obj["title"]);
                if (!$movname->save())
                {
                    http_response_code(500);
                    echo "Error encountered while adding title $title_obj[title] to movie $movie_id";
                    $mov->delete();
                    return false;
                }
                $countries[] = $title_obj["iso_3166_1"];
            }

            $credits_json = file_get_contents_utf8($credits_url);
            $credits_obj = json_decode($credits_json, true);

            $actor_query_obj = new Actor();
            foreach ($credits_obj["cast"] as $api_actor)
            {
                $actor = $actor_query_obj->get($api_actor["id"]);
                if ($actor == null)
                {
                    $actor = Actor::CreateActor($api_actor["id"], $api_actor["name"]);
                    if (!$actor->save())
                    {
                        http_response_code(500);
                        echo "Error encountered while adding actor $api_actor[name] to database";
                        $mov->delete();
                        return false;
                    }
                }
                if (!$mov->addActor($actor->getIdActor()))
                {
                    http_response_code(500);
                    echo "Error encountered while adding actor $api_actor[name] to movie $movie_id";
                    $mov->delete();
                    return false;
                }
            }
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