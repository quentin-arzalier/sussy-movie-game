<?php
include 'Models/CRUDAble.php';
class User extends CRUDAble{
    /**
     * @var int
     */
    private $id_user;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email_address;

    /**
     * @var string
     */
    private $password_hash;

    /**
     * @var boolean
     */
    private $is_admin;


    public function __construct(){
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getIdUser(){
        return $this->id_user;
    }

    /**
     * @param int $id_user
     */
    public function setIdUser($id_user){
        $this->id_user = $id_user;
    }

    /**
     * @return string
     */
    public function getUsername(){
        return $this->username;
    }
    
    /**
     * @param string $username
     */
    public function setUsername($username){
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmailAddress(){
        return $this->email_address;
    }
    
    /**
     * @param string $email_address
     */
    public function setEmailAddress($email_address){
         $this->email_address = $email_address;
    }

    /**
     * @return string
     */
    public function getPasswordHash(){
        return $this->password_hash;
    }

    /**
     * @param string $password_hash
     */
    public function setPasswordHash($password_hash){
        $this->password_hash = $password_hash;
    }

    /**
     * @return boolean
     */
    public function getIsAdmin(){
        return $this->is_admin;
    }
    
    /**
     * @param boolean $is_admin
     */
    public function setIsAdmin($is_admin){
        $this->is_admin = $is_admin;
    }
    
    /**
     * @return array
     */
    public function getMovieHistory(){

    }

}