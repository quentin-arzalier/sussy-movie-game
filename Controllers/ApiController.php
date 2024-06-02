<?php

class ApiController
{
    public static function movies()
    {
        require_once "Models/ApiDTO/MovieListDTO.php";

        if (!isset($_GET['page']) || !is_numeric($_GET['page'])|| (int)$_GET['page'] <= 0)
        {
            http_response_code(400);
            echo  "Le paramètre 'page' est requis et doit être un entier.";
            return;
        }

        header('Content-type: application/json; charset=utf-8');

        $query_obj = new Movie();

        $totalMovies = $query_obj->countAllMovies();
        $movies = $query_obj->getAllMoviesPaginated($_GET['page'] - 1);

        $res = new MovieListDTO($_GET['page'], $totalMovies, $movies);

        echo json_encode($res);
    }

    public static function moviesDetails($id_movie)
    {
        require_once "Models/ApiDTO/MovieDetailsDTO.php";

        header('Content-type: application/json; charset=utf-8');

        $query_obj = new Movie();

        $movie = $query_obj->get($id_movie);
        if ($movie == null)
        {
            http_response_code(404);
            return;
        }

        $res = new MovieDetailsDTO($movie);

        echo json_encode($res);
    }
}