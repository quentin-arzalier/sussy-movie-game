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
        if(empty($_SESSION['attempt_count'])) $_SESSION['attempt_count'] = 1;
        else $_SESSION['attempt_count'] = $_SESSION['attempt_count'] + 1;
        $guess_id = $_POST["movie_id"];
        $movie_attempt = (new Movie())->get($guess_id);
        $id_real_movie = GameController::randomMovie();
        $real_movie = (new Movie())->get($id_real_movie);
        if($guess_id == $id_real_movie){
            $_SESSION['id_movie'] = $guess_id;
            $_SESSION['date_of_success'] = date('Y-m-d');
            GameController::addMovieHistorical();
        }
        require_once get_file_path(array("Views", "Game", "attempt.php"));
    }

    private static function addMovieHistorical(){
        $userMovieHistory = new UserMovieHistory();
        $rep = $userMovieHistory->addMovieHistorical($_SESSION['login'], $_SESSION["id_movie"], $_SESSION["attempt_count"], $_SESSION["date_of_success"]);
        if(!$rep){
            print("Le film n'a pas été ajouté à l'historique.");
        }
    }

    private static function randomMovie(): int{
        $date = date('dmY');
        srand($date);
        $random = rand();
        $id_movies = (new Movie())->getAllIdMovies();
        return $id_movies[$random % count($id_movies)]; // retourn un id de film de manière aléatoir qui change chaque jour
    }
}