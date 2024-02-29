<?php
class MovieController
{
    public static function index()
    {
        $mov = new Movie();
        $movies = $mov->getAllMovies();

        //TODO : faire mieux
        $view_name = "Views/Movie/index.php";
        require_once "Views/Shared/layout.php";
    }

    public static function search()
    {
        $view_name = "Views/Movie/search.php";
        require_once "Views/Shared/layout.php";
    }
}