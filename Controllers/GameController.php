<?php
class GameController
{
    // TODO : Générer un seul film par jour
    // TODO : Incrémenter nombre d'essai utilisateur
    public static function GuessMovie(): void
    {
        if($_SERVER["REQUEST_METHOD"] != "POST") {
            http_response_code(404);
            return;
        }
        $guess_id = $_POST["movie_id"];
        $movie_attempt = (new Movie())->get($guess_id);
        $real_movie = (new Movie())->get(299534); // The Fast and the Furious
        require_once get_file_path(array("Views", "Game", "attempt.php"));
    }

    public static function addMovieHistorical(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if(empty($_POST["id_movie"]) || empty($_POST["attempt_count"]) || empty($_POST["date_of_success"])) {
                $view_name = "Views/Error/404.php";
                require_once "Views/Shared/layout.php";
                return;
            }
            $userMovieHistory = new UserMovieHistory();
            $rep = $userMovieHistory->addMovieHistorical($_SESSION['login'], $_POST["id_movie"], $_POST["attempt_count"], $_POST["date_of_success"]);
            if(!$rep){
                alert("Une erreur est survenue lors de la sauvegarde dans l'historique du film.");
            }
        }
    }
}