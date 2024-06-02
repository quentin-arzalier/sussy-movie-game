<?php
Class MovieName extends CRUDAble implements JsonSerializable {

    private int $id_movie;

    private string $country_code;

    private string $name;

    public function __construct(){
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

    public function getCountryCode(): string
    {
        return $this->country_code;
    }

    public function setCountryCode(string $country_code): void
    {
        $this->country_code = $country_code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }



    public function get($movie_id, $country_code): MovieName|null
    {
        $query = $this->getPDO()->prepare("
SELECT * FROM movie_name
WHERE id_movie=:id_movie AND country_code=:country_code
");
        $response = $query->execute(array(
            'id_movie' => $movie_id,
            'country_code' => $country_code,
        ));
        if (!$response)
            return null;

        $array = $query->fetchAll(PDO::FETCH_CLASS, 'MovieName');

        if (count($array) == 1)
            return $array[0];
        else
            return null;
    }

    public static function CreateMovieName($movie_id, $country_code, $name): MovieName
    {
        $movname = new MovieName();
        $movname->setIdMovie($movie_id);
        $movname->setCountryCode($country_code);
        $movname->setName($name);
        return $movname;
    }

    public static function SaveManyMovieNames(array $movie_names): bool
    {
        $query_obj = new MovieName();
        try {
            $queryString = "
INSERT INTO movie_name(country_code, id_movie, name)
VALUES
            ";
            $i = 0;
            $params = array();
            $count = count($movie_names);
            foreach ($movie_names as $movie_name)
            {
                $queryString = $queryString . "(:country_code_$i, :id_movie_$i, :name_$i)";
                if ($i < $count - 1)
                    $queryString = $queryString . ",\n";
                else
                    $queryString = $queryString . ";";

                $params["country_code_$i"] = $movie_name->getCountryCode();
                $params["id_movie_$i"] = $movie_name->getIdMovie();
                $params["name_$i"] = $movie_name->getName();
                $i++;
            }
            $query = $query_obj->getPDO()->prepare($queryString);
            return $query->execute($params);
        }
        catch (Exception)
        {
            return false;
        }
    }

    public function save(): bool
    {
        if ($this->get($this->getIdMovie(), $this->getCountryCode()))
            return false;

        $query = $this->getPDO()->prepare("
INSERT INTO movie_name(id_movie, country_code, name) 
VALUES (:id_movie, :country_code, :name);
        ");

        return $query->execute(array(
            'id_movie' => $this->getIdMovie(),
            'country_code' => $this->getCountryCode(),
            'name' => $this->getName(),
        ));
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}