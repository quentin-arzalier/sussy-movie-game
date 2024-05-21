<?php
use Random\Randomizer;
class GameController
{
    public static function GuessMovie(): void
    {
        if($_SERVER["REQUEST_METHOD"] != "POST") {
            http_response_code(404);
            return;
        }
        $id_real_movie = (new Movie())->randomMovie();
        $real_movie = (new Movie())->get($id_real_movie);
        if(empty($_SESSION['attempt_count'])) $_SESSION['attempt_count'] = 1;
        else $_SESSION['attempt_count'] = $_SESSION['attempt_count'] + 1;
        $guess_id = $_POST["movie_id"];
        $movie_attempt = (new Movie())->get($guess_id);

        if(empty($_SESSION['guessed_movies'])) {
            $_SESSION['guessed_movies'] = array();
        }

        if($guess_id == $id_real_movie){
            $_SESSION['id_movie'] = $guess_id;
            $_SESSION['date_of_success'] = date('Y-m-d');
            GameController::addMovieHistory();
        }
        $_SESSION['guessed_movies'][] = serialize($movie_attempt->serializeData());
        require_once get_file_path(array("Views", "Game", "attempt.php"));
    }

    private static function addMovieHistory(){
        $userMovieHistory = new UserMovieHistory();
        $rep = $userMovieHistory->addMovieHistory($_SESSION['login'], $_SESSION["id_movie"], $_SESSION["attempt_count"], $_SESSION["date_of_success"]);
        if(!$rep){
            print("Le film n'a pas été ajouté à l'historique.");
        }
    }
}