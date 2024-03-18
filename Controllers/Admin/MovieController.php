<?php
class MovieController
{
    public static function index()
    {
        // TODO : Pagination
        $mov = new Movie();
        $movies = $mov->getAllMovies();

        //TODO : faire mieux
        $view_name = "Views/Movie/index.php";
        require_once "Views/Shared/admin_layout.php";
    }

    public static function add()
    {
        $mov = new Movie();
        $movies = $mov->getAllMovies();

        $view_name = "Views/Movie/add.php";
        require_once "Views/Shared/admin_layout.php";
    }
}