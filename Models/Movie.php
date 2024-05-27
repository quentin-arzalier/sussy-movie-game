<?php
class Movie extends CRUDAble
{
    /**
     * Id du film tel qu'indiqué par TMDB
     */
    private int $id_movie;
    /**
     * Le nom original du film
     */
    private string $original_name;
    /**
     * Date de sortie du film en format chaîne de caractères
     */
    private string $release_date;
    /**
     * Durée du film en minute
     */
    private int $runtime;

    private string|null $backdrop_path;
    private string|null $poster_path;

    public function __construct()
    {
        parent::__construct();
    }

    public function serializeData()
    {
        return [
            'id_movie' => $this->id_movie,
            'original_name' => $this->original_name,
            'release_date' => $this->release_date,
            'runtime' => $this->runtime,
            'backdrop_path' => $this->backdrop_path,
            'poster_path' => $this->poster_path,
        ];
    }

    // Méthode pour recréer l'objet à partir des données sérialisées
    public static function deserializeData($data)
    {
        $movie = new self();
        $movie->id_movie = $data['id_movie'];
        $movie->original_name = $data['original_name'];
        $movie->release_date = $data['release_date'];
        $movie->runtime = $data['runtime'];
        $movie->backdrop_path = $data['backdrop_path'];
        $movie->poster_path = $data['poster_path'];
        return $movie;
    }



    public static function GetMoviesByName(string $search, string $username): array|null
    {
        $mov_query_obj = new Movie();
        $query = $mov_query_obj->getPDO()->prepare("
SELECT m.* 
FROM `movie` m
JOIN `user` u ON u.username = :username
LEFT JOIN `movie_name` mn ON mn.id_movie = m.id_movie AND mn.country_code = u.country_code
WHERE LOWER(m.original_name) LIKE LOWER(:search_a)
OR LOWER(COALESCE(mn.name ,'')) LIKE LOWER(:search_b);
");
        $params = array(
            'username' => $username,
            'search_a' => $search,
            'search_b' => $search,
        );
        if (strlen($search) > 2)
        {
            $params["search_a"] = "%$search%";
            $params["search_b"] = "%$search%";
        }
        $response = $query->execute($params);
        if (!$response)
            return null;

        return $query->fetchAll(PDO::FETCH_CLASS, 'Movie');
    }


    public function getIdMovie(): int
    {
        return $this->id_movie;
    }
    public function setIdMovie(int $id_movie): void
    {
        $this->id_movie = $id_movie;
    }


    public function getOriginalName(): string
    {
        return $this->original_name;
    }
    public function setOriginalName(string $original_name): void
    {
        $this->original_name = $original_name;
    }

    public function getReleaseDate(): string
    {
        return $this->release_date;
    }
    public function setReleaseDate(string $release_date): void
    {
        $this->release_date = $release_date;
    }

    public function getBackdropPath(): string|null
    {
        return $this->backdrop_path;
    }

    public function setBackdropPath(string|null $backdrop_path): void
    {
        $this->backdrop_path = $backdrop_path;
    }

    public function getPosterPath(): string|null
    {
        return $this->poster_path;
    }

    public function setPosterPath(string|null $poster_path): void
    {
        $this->poster_path = $poster_path;
    }

    public function getRuntime(): int
    {
        return $this->runtime;
    }
    public function setRuntime(int $runtime): void
    {
        $this->runtime = $runtime;
    }



    public function getPosterUrl(): string
    {
        if ($this->getPosterPath() == null || $this->getPosterPath() == "")
            return "/Resources/img/no_poster.jpg";
        return "https://image.tmdb.org/t/p/w185" . $this->getPosterPath();
    }
    public function getBackdropUrl(): string
    {
        if ($this->getBackdropPath() == null || $this->getBackdropPath() == "")
            return "";
        return "https://image.tmdb.org/t/p/w780" . $this->getBackdropPath();
    }





    public function getAllMovies(): array
    {
        $response = $this->getPDO()->query("SELECT * FROM movie");
        return $response->fetchAll(PDO::FETCH_CLASS, 'Movie');
    }

    public function getAllIdMovies(): array
    {
        $response = $this->getPDO()->query("SELECT id_movie FROM movie");
        return $response->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getAllMoviesPaginated(int $page): array|null
    {
        $query = $this->getPDO()->prepare("
SELECT * FROM movie
ORDER BY original_name
LIMIT :limit OFFSET :offset
");
        $response = $query->execute(array('limit' => self::PAGE_SIZE, 'offset' => $page * self::PAGE_SIZE));
        if (!$response)
            return null;

        return $query->fetchAll(PDO::FETCH_CLASS, 'Movie');
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

    public static function CreateMovie(
        int $movie_id, string $original_name, string $release_date,
        int $runtime, string|null $backdrop_path, string|null $poster_path): Movie
    {
        $mov = new Movie();
        $mov->setIdMovie($movie_id);
        $mov->setOriginalName($original_name);
        $mov->setReleaseDate($release_date);
        $mov->setRuntime($runtime);
        $mov->setBackdropPath($backdrop_path);
        $mov->setPosterPath($poster_path);
        return $mov;
    }

    public function save(): bool
    {
        if ($this->get($this->getIdMovie()) != null)
            return false;

        $query = $this->getPDO()->prepare("
INSERT INTO movie(id_movie, original_name, release_date, runtime, backdrop_path, poster_path) 
VALUES (:id_movie, :original_name, :release_date, :runtime, :backdrop_path, :poster_path);
        ");

        return $query->execute(array(
            'id_movie' => $this->getIdMovie(),
            'original_name' => $this->getOriginalName(),
            'release_date' => $this->getReleaseDate(),
            'runtime' => $this->getRuntime(),
            'backdrop_path' => $this->getBackdropPath(),
            'poster_path' => $this->getPosterPath()
        ));
    }

    public function delete(): bool{
        $query = $this->getPDO()->prepare("
DELETE FROM movie
WHERE id_movie=:id_movie;
        ");
        return $query->execute(array(
            "id_movie" => $this->getIdMovie()
        ));
    }

    public function addGenre(int $genre_id): bool
    {
        $genre_query_obj = new Genre();
        if ($this->get($this->getIdMovie()) == null || $genre_query_obj->get($genre_id) == null)
            return false;

        $query = $this->getPDO()->prepare("
INSERT INTO movie_genre(id_movie, id_genre) 
VALUES (:id_movie, :id_genre);
");
        return $query->execute(array(
            'id_movie' => $this->getIdMovie(),
            'id_genre' => $genre_id,
        ));
    }

    public function addActor(int $actor_id): bool
    {
        $actor_query_obj = new Actor();
        if ($this->get($this->getIdMovie()) == null || $actor_query_obj->get($actor_id) == null)
            return false;

        $query = $this->getPDO()->prepare("
INSERT INTO movie_actor(id_movie, id_actor) 
VALUES (:id_movie, :id_actor);
");
        return $query->execute(array(
            'id_movie' => $this->getIdMovie(),
            'id_actor' => $actor_id,
        ));
    }

    public function addManyActors(array $actor_ids): bool
    {
        try {
            $queryString = "
INSERT INTO movie_actor(id_movie, id_actor)
VALUES
            ";
            $i = 0;
            $params = array();
            $count = count($actor_ids);
            foreach ($actor_ids as $actor_id)
            {
                $queryString = $queryString . "(:id_movie_$i, :id_actor_$i)";
                if ($i < $count - 1)
                    $queryString = $queryString . ",\n";
                else
                    $queryString = $queryString . ";";
                $params["id_actor_$i"] = $actor_id;
                $params["id_movie_$i"] = $this->getIdMovie();
                $i++;
            }
            $query = $this->getPDO()->prepare($queryString);
            return $query->execute($params);
        }
        catch (Exception)
        {
            return false;
        }
    }

    public function addManyDirectors(array $director_ids): bool
    {
        try {
            $queryString = "
INSERT INTO movie_director(id_movie, id_director)
VALUES
            ";
            $i = 0;
            $params = array();
            $count = count($director_ids);
            foreach ($director_ids as $director_id)
            {
                $queryString = $queryString . "(:id_movie_$i, :id_director_$i)";
                if ($i < $count - 1)
                    $queryString = $queryString . ",\n";
                else
                    $queryString = $queryString . ";";
                $params["id_director_$i"] = $director_id;
                $params["id_movie_$i"] = $this->getIdMovie();
                $i++;
            }
            $query = $this->getPDO()->prepare($queryString);
            return $query->execute($params);
        }
        catch (Exception)
        {
            return false;
        }
    }

    public function addDirector(int $director_id): bool
    {
        $director_query_obj = new Director();
        if ($this->get($this->getIdMovie()) == null || $director_query_obj->get($director_id) == null)
            return false;

        $query = $this->getPDO()->prepare("
INSERT INTO movie_director(id_movie, id_director) 
VALUES (:id_movie, :id_director);
");
        return $query->execute(array(
            'id_movie' => $this->getIdMovie(),
            'id_director' => $director_id,
        ));
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

    public function countAllMovies(): int
    {
        $response = $this->getPDO()->query("SELECT COUNT(*) FROM movie");
        return $response->fetchAll(PDO::FETCH_NUM)[0][0];
    }

    public static function randomMovie(): int{
        $date = date('dmY');
        srand($date);
        $random = rand();
        $id_movies = (new Movie())->getAllIdMovies();
        return $id_movies[$random % count($id_movies)]; // retourn un id de film de manière aléatoir qui change chaque jour
    }
}