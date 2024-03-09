<?php

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

    /**
     * @var boolean
     */
    private $is_verify;


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
    private function setIdUser($id_user){
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
    private function setUsername($username){
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
    private function setEmailAddress($email_address){
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
    private function setPasswordHash($password_hash){
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
    private function setIsAdmin($is_admin){
        $this->is_admin = $is_admin;
    }

    /**
     * @return boolean
     */
    public function getIsVerify(){
        return $this->is_verify;
    }
    
    /**
     * @param boolean $is_verify
     */
    private function setIsVerify($is_verify){
        $this->is_verify = $is_verify;
    }

    private function setUser($user){
        $this->setIdUser($user->getIdUser());
        $this->setUsername($user->getUsername());
        $this->setEmailAddress($user->getEmailAddress());
        $this->setPasswordHash($user->getPasswordHash());
        $this->setIsAdmin($user->getIsAdmin());
        $this->setIsVerify($user->getIsVerify());
    }

    public function newUser($username, $email_address, $password){
        $password_hash = password_hash($password . HASH_SALT, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(50));

        $req = $this->getPDO()->prepare('INSERT INTO user (username, email_address, password_hash, token_verify) VALUES (:champ1, :champ2, :champ3, :champ4)');
        $req->execute(array(
        'champ1' => $username,
        'champ2' => $email_address,
        'champ3' => $password_hash,
        'champ4' => $token
        ));
        $this->setUsername($username);
        $this->setEmailAddress($email_address);
        $this->setPasswordHash($password_hash);
        $this->setIsAdmin(false);
        $this->setIsVerify(false);

        $verification_url = "http://sussy-movie-game/user/verifyaccount?token=$token";
        mail($this->getEmailAddress(), 'Vérifiez votre email pour The Sussy Movie Game', "Cliquez ici pour valider votre inscription à The Sussy Movie Game ! \n\n $verification_url");
    }

    /**
     * @return int
     */
    public function verifyAccount($token){
        $req = $this->getPDO()->prepare("UPDATE user SET email_chek = 1 WHERE token_verify =:champ1");
        $req->execute(array(
            'champ1' => $token
        ));
        return $req->rowCount();
    }

    /**
     * @return boolean
     */
    public function connectUser($username, $password){
        $req = $this->getPDO()->prepare("SELECT * FROM user WHERE username =:champ1");
        $req->execute(array(
            'champ1'=> $username,
            ));
        $response = $req->fetchAll(PDO::FETCH_CLASS, 'User');
        if(count($response) == 1){
            $user = $response[0];
            $is_password = password_verify($password . HASH_SALT, $user->getPasswordHash());
            $this->setUser($user);
            return $is_password;
        } else {
            return false;
        }        
    }
    
    /**
     * @return array
     */
    public function getMovieHistory(){

    }

    public function __toString(){
        return 'ID Utilisateur : ' . $this->id_user . 'Nom utilisateur : ' . $this->username .'Adresse mail : '. $this->email_address .'Est administrateur : '. $this->is_admin;
    }

    public function save(): bool{ 
    } 
}