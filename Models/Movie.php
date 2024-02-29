<?php
class Movie extends CRUDAble
{
    /**
     * Id du film tel qu'indiqué par TMDB
     */
    private int $id_movie;
    /**
     * Country code du pays d'origine du film
     */
    private string $original_language;
    /**
     * Date de sortie du film en format chaîne de caractères
     */
    private string $release_date;
    /**
     * Durée du film en minute
     */
    private int $runtime;

    /**
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function getIdMovie(): int
    {
        return $this->id_movie;
    }
    public function setIdMovie(int $id_movie): void
    {
        $this->id_movie = $id_movie;
    }


    public function getOriginalLanguage(): string
    {
        return $this->original_language;
    }
    public function setOriginalLanguage(string $original_language): void
    {
        $this->original_language = $original_language;
    }

    public function getReleaseDate(): string
    {
        return $this->release_date;
    }
    public function setReleaseDate(string $release_date): void
    {
        $this->release_date = $release_date;
    }


    public function getRuntime(): int
    {
        return $this->runtime;
    }
    public function setRuntime(int $runtime): void
    {
        $this->runtime = $runtime;
    }

    /**
     * @return array<Movie>
     */
    public function getAllMovies(): array
    {
        $response = $this->getPDO()->query("SELECT * FROM movie");
        return $response->fetchAll(PDO::FETCH_CLASS, 'Movie');
    }

    public function get($movie_id): Movie|null
    {
        $query = $this->getPDO()->prepare("
SELECT * FROM movie
WHERE id_movie=:id_movie
");
        $response = $query->execute(array('id_movie' => $movie_id));
        if (!$response)
            return null;

        $array = $query->fetchAll(PDO::FETCH_CLASS, 'Movie');

        if (count($array) == 1)
            return $array[0];
        else
            return null;
    }

    public static function CreateMovie(int $movie_id, string $original_language, string $release_date, int $runtime): Movie
    {
        $mov = new Movie();
        $mov->setIdMovie($movie_id);
        $mov->setOriginalLanguage($original_language);
        $mov->setReleaseDate($release_date);
        $mov->setRuntime($runtime);
        return $mov;
    }

    public function save(): bool
    {
        if ($this->get($this->getIdMovie()) != null)
            return false;

        $query = $this->getPDO()->prepare("
INSERT INTO movie(id_movie, original_language, release_date, runtime) 
VALUES (:id_movie, :original_language, :release_date, :runtime);
        ");


        return $query->execute(array(
            'id_movie' => $this->getIdMovie(),
            'original_language' => $this->getOriginalLanguage(),
            'release_date' => $this->getReleaseDate(),
            'runtime' => $this->getRuntime(),
        ));
    }



    //faire des GET requets SQL
    public function getMovieActor(){
    }
    public function getMoviekKnd(){
    }
    public function getMovieDirectors(){
    }
    public function getMovieNames(){
    }
}