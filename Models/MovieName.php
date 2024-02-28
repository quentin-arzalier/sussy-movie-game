<?php
include 'Models/CRUDAble.php';
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
    public function getLanguage(){
        return $this->country_code;
    }
    
    /**
     * @param string $country_code
     */
    public function setIdLanguage($country_code){
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
}