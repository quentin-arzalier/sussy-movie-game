<?php
include 'Models/CRUDAble.php';
Class UserMovieHistory extends CRUDAble{
    
    /**
     * @var int
     */
    private $id_user;

    /**
     * @var int
     */
    private $id_movie;

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
     * @return int
     */
    public function getUsername(){
        return $this->id_user;
    }

    /**
     * @param int
     */
    public function setUsername($id_user){
        $this->$id_user = $id_user;
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
        $this->$id_movie = $id_movie;
    }

    /**
     * @return int
     */
    public function getAttemptCount(){
        return $this->attempt_count;
    }

    /**
     * @param int $attempt_count
     */
    public function setAttemptCount($attempt_count){
        $this->attempt_count = $attempt_count;
    }

    /**
     * @return string
     */
    public function getDateOfSuccess(){
        return $this->date_of_success;
    }
    
    /**
     * @param string $date_of_success
     */
    public function setDateOfSuccess($date_of_success){
        $this->date_of_success = $date_of_success;
    }


}