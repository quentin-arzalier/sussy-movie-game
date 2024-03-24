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

}