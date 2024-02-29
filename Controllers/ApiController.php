<?php

class ApiController
{
    public static function searchMovieByName()
    {
        $name = $_GET["name"];
        $nameParam = urlencode($name);
        $api_url = "https://api.themoviedb.org/3/search/movie?query=$nameParam&page=1&api_key=" . API_KEY;
        echo file_get_contents($api_url);
    }
}