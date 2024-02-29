<?php
include 'Models/CRUDAble.php';

class Movie extends CRUDAble
{
    /**
     * @var int
     */
    private $id_movie;

    /**
     * @var string
     */
    private $original_language;

    private $release_date;

    /**
     * @var int Durée du film en minute
     */
    private $runtime;

    /**
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getIdMovie()
    {
        return $this->id_movie;
    }

    /**
     * @param int $id_movie
     */
    public function setIdMovie($id_movie)
    {
        $this->id_movie = $id_movie;
    }

    /**
     * @return string
     */
    public function getOriginalLanguage()
    {
        return $this->original_language;
    }

    /**
     * @param string $original_language
     */
    public function setOriginalLanguage($original_language)
    {
        $this->original_language = $original_language;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate()
    {
        return $this->release_date;
    }

    /**
     * @param mixed $release_date
     */
    public function setReleaseDate($release_date)
    {
        $this->release_date = $release_date;
    }

    /**
     * @return int
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * @param int $runtime
     */
    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;
    }

    /**
     * @return array<Movie>
     */
    public function getAllMovies()
    {
        $response = $this->getPDO()->query("SELECT * FROM movie");
        return $response->fetchAll(PDO::FETCH_CLASS, 'Movie');
    }

    public function getById($movie_id)
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


    public function save($movie_id, $original_language, $release_date, $runtime): bool
    {
        if ($this->getById($movie_id))
            return false;

        $query = $this->getPDO()->prepare("
INSERT INTO movie(id_movie, original_language, release_date, runtime) 
VALUES (:id_movie, :original_language, :release_date, :runtime);
        ");

        return $query->execute(array(
            'id_movie' => $movie_id,
            'original_language' => $original_language,
            'release_date' => $release_date,
            'runtime' => $runtime,
        ));
    }



    //faire des GET requets SQL
        /**
     * @return array
     */
    public function getMovieActor(){
    }

    /**
     * @return array
     */
    public function getMoviekKnd(){

    }

    /**
     * @return array
     */
    public function getMovieDirectors(){

    }

    /**
     * @return array
     */
    public function getMovieName(){

    }
}