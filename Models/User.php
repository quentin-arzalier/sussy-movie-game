<?php

class User extends CRUDAble
{


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

    private $token_verify;

    private $email_chek;
    public function __construct() {
        parent::__construct();
    }

    /**
     * @return int
     */

    /**
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @param string $username
     */
    private function setUsername($username) {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmailAddress() {
        return $this->email_address;
    }

    /**
     * @param string $email_address
     */
    private function setEmailAddress($email_address) {
        $this->email_address = $email_address;
    }

    /**
     * @return string
     */
    public function getPasswordHash() {
        return $this->password_hash;
    }

    /**
     * @param string $password_hash
     */
    private function setPasswordHash($password_hash) {
        $this->password_hash = $password_hash;
    }

    /**
     * @return boolean
     */
    public function getIsAdmin() {
        return $this->is_admin;
    }

    /**
     * @return string
     */
    public function getTokenVerify() {
        return $this->token_verify;
    }

    /**
     * @param boolean $is_admin
     */
    private function setIsAdmin($is_admin) {
        $this->is_admin = $is_admin;
    }

    /**
     * @return boolean
     */
    public function getIsVerify() {
        return $this->is_verify;
    }

    /**
     * @param boolean $is_verify
     */
    private function setIsVerify($is_verify) {
        $this->is_verify = $is_verify;
    }

    /**
     * @return boolean
     */
    public function getEmailChek() {
        return $this->email_chek;
    }

    private function createPasswordHash($password) {
        return password_hash($password . HASH_SALT, PASSWORD_DEFAULT);
    }

    private function setUser($user) {
        $this->setUsername($user->getUsername());
        $this->setEmailAddress($user->getEmailAddress());
        $this->setPasswordHash($user->getPasswordHash());
        $this->setIsAdmin($user->getIsAdmin());
        $this->setIsVerify($user->getIsVerify());
    }

    public function newUser($username, $email_address, $password)
    {
        $password_hash = $this->createPasswordHash($password);
        $token_verify = bin2hex(random_bytes(50));

        $req = $this->getPDO()->prepare('INSERT INTO user (username, email_address, password_hash, token_verify) VALUES (:champ1, :champ2, :champ3, :champ4)');
        $req->execute(
            array(
                'champ1' => $username,
                'champ2' => $email_address,
                'champ3' => $password_hash,
                'champ4' => $token_verify
            )
        );
        $this->setUsername($username);
        $this->setEmailAddress($email_address);
        $this->setPasswordHash($password_hash);
        $this->setIsAdmin(false);
        $this->setIsVerify(false);

        $verification_url = "http://sussy-movie-game/user/verifyaccount?token=$token_verify";
        mail($this->getEmailAddress(), 'Vérifiez votre email pour The Sussy Movie Game', "Cliquez ici pour valider votre inscription à The Sussy Movie Game ! \n\n $verification_url");
    }

    /**
     * @return int
     */
    public function verifyAccount($token) {
        $req = $this->getPDO()->prepare("UPDATE user SET email_chek = 1 WHERE token_verify =:champ1");
        $req->execute(
            array(
                'champ1' => $token
            )
        );
        return $req->rowCount();
    }

    /**
     * @return boolean
     */
    public function connectUser($username, $password) {
        $req = $this->getPDO()->prepare("SELECT * FROM user 
        WHERE username =:champ1");
        $req->execute(
            array(
                'champ1' => $username,
            )
        );
        $response = $req->fetchAll(PDO::FETCH_CLASS, 'User');
        if (count($response) == 1) {
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
    public function getMovieHistory() {

    }


    public function changePassword($username, $oldpassword, $newpassword) { // TODO : ne fonctionne pas
        $this->setUsername($username);
        $old_password_hash = $this->createPasswordHash($oldpassword);
        $new_password_hash = $this->createPasswordHash($newpassword);
        $req = $this->getPDO()->prepare("SELECT * FROM user 
        WHERE username =:champ1 AND password_hash =:old_password_hash");
        $req->execute(
            array(
                'champ1' => $username,
                'old_password_hash' => $old_password_hash
            )
        );
        $response = $req->fetchAll(PDO::FETCH_CLASS, 'User');
        var_dump($response);
        if (count($response) == 1) {
            $user = $response[0];
            if (password_verify($oldpassword . HASH_SALT, $user->getPasswordHash())) {
                $req = $this->getPDO()->prepare("UPDATE password_hash FROM user 
            WHERE username =:champ1 AND password_hash =:new_password_hash"); // pas bon voir updateAdmin
                $req->execute(
                    array(
                        'champ1' => $username,
                        'new_password_hash' => $new_password_hash
                    )
                );
                $this->setPasswordHash($new_password_hash);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getAllUsers() {
        $req = $this->getPDO()->query('SELECT * FROM user');
        return $req->fetchAll(PDO::FETCH_CLASS, 'User');
    }

    public function deleteUser($username){
        $req = $this->getPDO()->prepare('DELETE * FROM user WHERE username=:username');
        $req->execute(
            array(
                'username' => $username
            )
        );
    }

    public function updateAdmin($username){
        $req = $this->getPDO()->prepare('SELECT is_admin FROM user
        WHERE username =:username');
        $req->execute(
            array(
                'username' => $username
            )
        );
        $req->fetchColumn() ? $new_is_admin = 0 : $new_is_admin = 1 ;
        $req = $this->getPDO()->prepare('UPDATE user SET is_admin = :new_is_admin WHERE username = :username');
        $req->execute(
            array(
                'new_is_admin' => $new_is_admin,
                'username' => $username  
            )
        );
    }

    public function save(): bool {
    }
}