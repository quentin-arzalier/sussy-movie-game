<?php
    class UserMovieHistory extends CRUDAble{

    /**
     * @var string
     */
    private $username;

    /**
     * @var int
     */
    private $id_movie;

    /**
     * @var string
     */
    private $original_name;

    /**
     * @var string
     */
    private $original_language;

    /**
     * @var string
     */
    private $release_date;

    /**
     * @var int
     */
    private $runtime;

    /**
     * @var string
     */
    private $backdrop_path;

    /**
     * @var string
     */
    private $poster_path;

    /**
     * @var int
     */
    private $attempt_count;

    /**
     * @var string
     */
    private $date_of_success;

    public function __construct(){
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getUsername() : string {
        return $this->username;
    }

    /**
     * @param string $original_language
     */
    public function setUsername(string $username) {
        $this->username = $username;
    }

    /**
     * @return int
     */
    public function getIdMovie() : int {
        return $this->id_movie;
    }

    /**
     * @param int $id_movie
     */
    public function setIdMovie(int $id_movie) {
        $this->id_movie = $id_movie;
    }

    /**
     * @return string
     */
    public function getOriginalName() : string {
        return $this->original_name;
    }

    /**
     * @param string $original_language
     */
    public function setOriginalName(string $original_name) {
        $this->original_name = $original_name;
    }

    /**
     * @return string
     */
    public function getOriginalLanguage() : string {
        return $this->original_language;
    }

    /**
     * @param string $original_language
     */
    public function setOriginalLanguage(string $original_language) {
        $this->original_language = $original_language;
    }

    /**
     * @return string
     */
    public function getReleaseDate() : string {
        return $this->release_date;
    }

    /**
     * @param string $release_date
     */
    public function setReleaseDate(string $release_date) {
        $this->release_date = $release_date;
    }

    /**
     * @return int
     */
    public function getRuntime() : int {
        return $this->runtime;
    }

    /**
     * @param int $runtime
     */
    public function setRuntime(int $runtime) {
        $this->runtime = $runtime;
    }

    /**
     * @return string
     */
    public function getBackdropPath() : string {
        return $this->backdrop_path;
    }

    /**
     * @param string $backdrop_path
     */
    public function setBackdropPath(string $backdrop_path) {
        $this->backdrop_path = $backdrop_path;
    }

    /**
     * @return string
     */
    public function getPosterPath() : string {
        return $this->poster_path;
    }

    /**
     * @param string $poster_path
     */
    public function setPosterPath(string $poster_path) {
        $this->poster_path = $poster_path;
    }

    /**
     * @return int
     */
    public function getAttemptCount() : int {
        return $this->attempt_count;
    }

    /**
     * @param int $attempt_count
     */
    public function setAttemptCount(int $attempt_count) {
        $this->attempt_count = $attempt_count;
    }

    /**
     * @return string
     */
    public function getDateOfSuccess() : string {
        return $this->date_of_success;
    }

    /**
     * @param string $date_of_success
     */
    public function setDateOfSuccess(string $date_of_success) {
        $this->date_of_success = $date_of_success;
    }

public function getPosterUrl(): string
    {
        if ($this->getPosterPath() == null || $this->getPosterPath() == "")
            return "/resources/img/no_poster.jpg";
        return "https://image.tmdb.org/t/p/w185" . $this->getPosterPath();
    }
    public function getBackdropUrl(): string
    {
        if ($this->getBackdropPath() == null || $this->getBackdropPath() == "")
            return "";
        return "https://image.tmdb.org/t/p/w780" . $this->getBackdropPath();
    }
/**
     * @return array<Actor>|null
     */
    public function getActors(): array|null
    {
        $query = $this->getPDO()->prepare("
SELECT a.* 
FROM actor a
NATURAL JOIN movie_actor ma
WHERE ma.id_movie = :id_movie;
        ");

        $response = $query->execute(array('id_movie' => $this->getIdMovie()));
        if (!$response)
            return null;

        return $query->fetchAll(PDO::FETCH_CLASS, 'Actor');
    }
/**
     * @return array<Director>|null
     */
    public function getDirectors(): array|null
    {
        $query = $this->getPDO()->prepare("
SELECT d.* 
FROM director d
NATURAL JOIN movie_director md
WHERE md.id_movie = :id_movie;
        ");

        $response = $query->execute(array('id_movie' => $this->getIdMovie()));
        if (!$response)
            return null;

        return $query->fetchAll(PDO::FETCH_CLASS, 'Director');
    }

    public function getHistoryMovies($username) {
        
        $req = $this->getPDO()->prepare("SELECT * FROM usermoviehistory
        INNER JOIN movie ON usermoviehistory.id_movie = movie.id_movie
        WHERE username = :username
        ORDER BY date_of_success DESC");
        $req->execute(
            array(
                'username' => $username
            )
        );
        return $req->fetchAll(PDO::FETCH_CLASS, 'UserMovieHistory');
    }

    public function getHistoryMoviesByDate($username, $today) {
        
        $req = $this->getPDO()->prepare("SELECT * FROM usermoviehistory
        INNER JOIN movie ON usermoviehistory.id_movie = movie.id_movie
        WHERE username = :username AND date_of_success = :today");
        $req->execute(
            array(
                'username' => $username,
                'today' => $today
            )
        );
        $req->fetchAll(PDO::FETCH_CLASS, 'UserMovieHistory');
        if($req->rowCount() > 0){
            return false;
        } else {
            return true;
        }
    } 

    public function addMovieHistory($login, $id_movie, $attempt_count, $date_of_success){
        try{
            $req = $this->getPDO()->prepare('INSERT INTO usermoviehistory  (username, id_movie, attempt_count, date_of_success) VALUES (:username, :id_movie, :attempt_count, :date_of_success)');
            $req->execute(
                array(
                    'username' => $login,
                    'id_movie' => $id_movie,
                    'attempt_count' => $attempt_count,
                    'date_of_success' => $date_of_success
                )
            );
            if ($req->rowCount() > 0) {
                return true;
            } else {
                throw new Exception("Aucune ligne affectée lors de l'insertion.");
            }
        } catch (PDOException $e) {
            error_log("Erreur PDO : " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Erreur : " . $e->getMessage());
            return false;
        }
    }

    public function countAllHistories($login): int
    {
        $req = $this->getPDO()->prepare("
SELECT COUNT(*)
FROM usermoviehistory
WHERE username = :login;
");
        $req->execute(
            array(
                'login' => $login
            )
        );
        return $req->fetchAll(PDO::FETCH_NUM)[0][0];
    }

    public function getHistoriesPaginated($username, int $page) {

        $req = $this->getPDO()->prepare("SELECT * FROM usermoviehistory
    INNER JOIN movie ON usermoviehistory.id_movie = movie.id_movie
    WHERE username = :username
    ORDER BY date_of_success DESC
    LIMIT :limit OFFSET :offset");
        $req->execute(
            array(
                'username' => $username,
                'limit' => self::PAGE_SIZE,
                'offset' => self::PAGE_SIZE * $page
            )
        );
        return $req->fetchAll(PDO::FETCH_CLASS, 'UserMovieHistory');
    }

    public function getByDate($username, $date): UserMovieHistory|null {

        $req = $this->getPDO()->prepare("SELECT * FROM usermoviehistory
INNER JOIN movie ON usermoviehistory.id_movie = movie.id_movie
WHERE username = :username AND date_of_success = :date");
        $res = $req->execute(
            array(
                'username' => $username,
                'date' => $date
            )
        );
        if (!$res)
            return null;

        $tmp = $req->fetchAll(PDO::FETCH_CLASS, 'UserMovieHistory');

        if (!$tmp || count($tmp) == 0)
            return null;

        return $tmp[0];
    }
    public function getTranslatedNameForUser($username): string|null
    {
        $query = $this->getPDO()->prepare("
SELECT COALESCE(mn.name, m.original_name) 
FROM `movie` m
JOIN `user` u ON u.username = :username
LEFT JOIN `movie_name` mn ON mn.id_movie = m.id_movie AND mn.country_code = u.country_code
WHERE m.id_movie = :id_movie
LIMIT 1;
    ");

        $res = $query->execute(array(
            "id_movie" => $this->getIdMovie(),
            "username" => $username
        ));
        if (!$res)
            return false;

        $all = $query->fetchAll(PDO::FETCH_COLUMN);

        if (count($all) != 1)
            return false;

        return $all[0];
    }

    public function save(): bool {}
}
?>