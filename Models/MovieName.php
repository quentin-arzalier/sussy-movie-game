<?php
Class MovieName extends CRUDAble{

    /**
     * @var int
     */
    private $id_movie;

    /**
     * @var string
     */
    private $country_code;

    /**
     * @var string
     */
    private $name;

    public function __construct(){
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getIdMovie(){
        return $this->id_movie;
    }

    /**
     * @param int $id_movie
     */
    public function setIdMovie($id_movie){
        $this->id_movie = $id_movie;
    }

    /**
     * @return string
     */
    public function getCountryCode(){
        return $this->country_code;
    }
    
    /**
     * @param string $country_code
     */
    public function setCountyCode($country_code){
        $this->country_code = $country_code;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string
     */
    public function setName($name){
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
        $movname->setCountyCode($country_code);
        $movname->setName($name);
        return $movname;
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
}