<?php
include 'Models/CRUDAble.php';
Class Actor extends CRUDAble{

    /**
     * @var int
     */
    private $id_actor;

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
    public function getIdActor(){
        return $this->id_actor;
    }

    /**
     * @param int $id_actor
     */
    public function setIdActor($id_actor){  
        $this->id_actor = $id_actor;
    }

    /**
     * @return string
     */
    public function getFirstName(){
        return $this->first_name;
    }   

    /**
     * @param string $first_name
     */
    public function setFitstName($first_name){
        $this->fitst_name = $first_name;
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
    public function setLasttName($last_name){
        $this->fitst_name = $last_name;
    }
}