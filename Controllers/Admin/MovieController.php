<?php
class MovieController
{
    public static function index()
    {

        $query_obj = new Movie();
        $total_movies = $query_obj->countAllMovies();


        if ($total_movies == 0)
        {
            $view_name = get_file_path(array("Views", "Admin", "Movie", "no_movies.php"));
            require_once get_file_path(array("Views", "Admin", "Shared", "admin_layout.php"));
            return;
        }


        $curr_page = 1;
        if (isset($_GET["page"]) && is_numeric($_GET["page"]) && (int)$_GET["page"] > 0)
        {
            $curr_page = (int)$_GET["page"];
        }

        $id_movie = null;
        if (isset($_GET["id_movie"]) && is_numeric($_GET["id_movie"]) && (int)$_GET["id_movie"] > 0)
        {
            $id_movie = (int)$_GET["id_movie"];
        }

        $page_size = Movie::PAGE_SIZE;

        $max_page = (int)ceil($total_movies / $page_size);

        if ($curr_page > $max_page)
            $curr_page = $max_page;

        $movies = $query_obj->getAllMoviesPaginated($curr_page - 1);


        if (count($movies) == 0 && $curr_page != 1)
        {
            $curr_page = 1;
            $movies = $query_obj->getAllMoviesPaginated($curr_page - 1);
        }

        $active_movie = $movies[0];

        if ($id_movie != null)
        {
            $active_movie = $query_obj->get($id_movie);
            if ($active_movie == null)
                $active_movie = $movies[0];
        }

        $view_name = get_file_path(array("Views", "Admin", "Movie", "index.php"));
        require_once get_file_path(array("Views", "Admin", "Shared", "admin_layout.php"));
    }

    public static function add()
    {
        $mov = new Movie();
        $movies = $mov->getAllMovies();

        $gen = new Genre();
        $genres = $gen->getAllGenres();

        if (count($genres) < 1)
        {
            require_once get_file_path(array("Controllers", "Admin", "ApiController.php"));
            ApiController::addAllNewGenres();
        }

        $view_name = get_file_path(array("Views", "Admin", "Movie", "add.php"));
        require_once get_file_path(array("Views", "Admin", "Shared", "admin_layout.php"));
    }
}