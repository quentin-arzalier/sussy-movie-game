<?php
Class UserController
{
    public static function index()
    {
        $view_name = "Views/User/connection.php";
        require_once "Views/Shared/layout.php";
    }

    public static function createpage(){
        $view_name = "Views/User/create.php";
        require_once "Views/Shared/layout.php";
    }

    public static function create(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if($_POST['password'] != $_POST['password_confirm']){
                echo 'Les mots de passe ne correspondent pas';
                UserController::createpage();
                return;
            }
            session_start();
            $_SESSION['login'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
            $user = new User();
            $user->newUser($_POST['username'],$_POST['email'],$_POST['password']);
               
        }
    }
    public static function connection(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $user = new User();
            $is_admin = $user->connectUser($_POST['username'], $_POST['password']);
            if($is_admin == false){
                echo "Votre nom d'utilisateur et/ou votre mot de passe est incorrect";
                UserController::index();
                return;
            }
            session_start();
            $_SESSION['login'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['is_admin'] = $is_admin;
            echo $user->__tostring();
        }
    }
    
}