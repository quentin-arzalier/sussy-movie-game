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

    public static function addMovieToDatabase()
    {
        if($_SERVER["REQUEST_METHOD"] != "POST") {
            http_response_code(404);
            return;
        }

        $movie_id = $_POST["movie_id"];
        $id_param = urlencode($movie_id);
        $details_url = "https://api.themoviedb.org/3/movie/$id_param?api_key=" . API_KEY;
        $titles_url = "https://api.themoviedb.org/3/movie/$id_param/alternative_titles?api_key=" . API_KEY;

        $details_json = file_get_contents($details_url);
        $details_obj = json_decode($details_json, true);
        $mov = new Movie();

        $mov->save(
            $details_obj["id"],
            $details_obj["original_language"],
            $details_obj["release_date"],
            $details_obj["runtime"]
        );

    }
}