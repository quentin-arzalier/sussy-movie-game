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
            $_SESSION['login'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
            $user = new User();
            $user->newUser($_POST['username'],$_POST['email'],$_POST['password']);
            UserController::account();
            return;
        }
    }
    public static function connection(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $user = new User();
            $is_ok = $user->connectUser($_POST['username'], $_POST['password']);
            if($is_ok == false){
                echo "Votre nom d'utilisateur et/ou votre mot de passe est incorrect";
                UserController::index();
                return;
            }
            $_SESSION['login'] = $_POST['username'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['is_admin'] = $user->getIsAdmin();
            UserController::account();
            return;
        }
    }

    public static function verifyaccount(){
        if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['token'])){
            $token = $_GET['token'];
            $user = new User();
            $is_modified = $user->verifyAccount($token);
            if($is_modified > 0){
                echo "Mail vérifié";
            }else{
                echo "Problème lors de la vérification";
            }
            UserController::account();
            return;
        } else {
            $view_name = "Views/Error/404.php";
            require_once "Views/Shared/layout.php";
        }
    }

    public static function changePassword(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $user = new User();
            $reponse = $user->changePassword($_SESSION['login'], $_POST['old_password'], $_POST["new_password"]);
            if($reponse){
                echo 'mdp changé';

            }else{
                echo 'mdp non changé';
            }
            UserController::index();
        }
    }

    public static function logout(){
        session_destroy();
        UserController::index();
        return;
    }
    public static function account(){
        $view_name = "Views/User/account.php";
        require_once "Views/Shared/layout.php";
    }

    public static function loginToContinue()
    {
        $view_name = "Views/User/loginToContinue.php";
        require_once "Views/Shared/layout.php";
    }

    public static function admin(){
        if($_SESSION['is_admin']){
            $user = new User();
            $users = $user->getAllUsers();
            $view_name = "Views/User/admin.php";
            require_once "Views/Shared/layout.php";
        } else {
            $view_name = "Views/Error/404.php";
            require_once "Views/Shared/layout.php";
        }
    }

    public static function updateAdmin(){
        if($_SESSION["is_admin"] && $_SERVER["REQUEST_METHOD"] == "POST"){
            $username = $_SERVER["username"];
            $user = new User();
            $user->updateAdmin($username);
            $view_name = "Views/User/admin.php";
            require_once "Views/Shared/layout.php";
        } else {
            $view_name = "Views/Error/404.php";
            require_once "Views/Shared/layout.php";
        }
}

    public static function deleteUser(){
        if($_SESSION["is_admin"] && $_SERVER["REQUEST_METHOD"] == "POST"){
            $username = $_SERVER["username"];
            $user = new User();
            $user->deleteUser($username);
            $view_name = "Views/User/admin.php";
            require_once "Views/Shared/layout.php";
        } else {
            $view_name = "Views/Error/404.php";
            require_once "Views/Shared/layout.php";
        }
    }
}