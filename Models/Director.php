<?php
include 'Controllers.CRUDAble.php';
Class Director extends CRUDAble{

    /**
     * @var int
     */
    private $id_director;

    /**
     * @var string
     */
    private $first_name;

    /**
     * @var string
     */
    private $last_name;

    public function __construct(){
    parent::__construct();
    }

    /**
     * @return int
     */
    public function getIdDirector(){ 
        return $this->id_director;
    }

    /**
     * @param int $id_director
     */
    public function setIdDirector($id_director){
        $this->id_director = $id_director;
    }

    /**
     * @return string
     */
    public function getFirstName(){
        return $this->first_name;
    }

    /**
     * @param string $fist_name
     */
    public function setFirstName($first_name){
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getLastName(){
        return $this->last_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName($last_name){
        $this->last_name = $last_name;
    }

}