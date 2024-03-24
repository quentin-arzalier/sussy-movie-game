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

    public static function forgotPassword(){
        $view_name = "Views/User/forgotPassword.php";
        require_once "Views/Shared/layout.php";
    }

    public static function historical(){
        if(empty($_SESSION['login'])){
            $view_name = "Views/Error/404.php";
            require_once "Views/Shared/layout.php";
            return;
        }
        $userMovieHistory = new UserMovieHistory();
        $histiryMovies = $userMovieHistory->getHistoricalMovies($_SESSION['login']);
        $view_name = "Views/User/historical.php";
        require_once "Views/Shared/layout.php";
    }

    public static function newPassword(){
        if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['token'])){
            $_SESSION['token'] = $_GET['token'];
            $view_name = "Views/User/newPassword.php";
            require_once "Views/Shared/layout.php";
        } else {
            $view_name = "Views/Error/404.php";
            require_once "Views/Shared/layout.php";
        }
    } 

    public static function create(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            if($_POST['password'] != $_POST['password_confirm']){
                $_SESSION['message'] = 'Les mots de passe ne correspondent pas';
                UserController::createpage();
                return;
            }
            
            $user = new User();
            $rep = $user->newUser($_POST['username'],$_POST['email'],$_POST['password']);
            if($rep){
                $_SESSION['message'] = 'Vérifier votre mail';
                UserController::index();
            } else {
                $_SESSION['message'] = 'Erreur veuillez réessayer';
                UserController::createpage();
            
            }
            return;
        }
    }
    public static function connection(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $user = new User();
            $is_ok = $user->connectUser($_POST['username'], $_POST['password']);
            if($is_ok == false){
                $_SESSION['message'] = "Votre nom d'utilisateur et/ou votre mot de passe est incorrect et/ou votre mail n'est pas vérifié";
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
                $_SESSION['message'] = "Mail vérifié";
            }else{
                $_SESSION['message'] = "Problème lors de la vérification";
            }
            UserController::index();
            return;
        } else {
            $view_name = "Views/Error/404.php";
            require_once "Views/Shared/layout.php";
        }
    }

    public static function changePassword(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
                if($_POST["new_password"] == $_POST["new_password2"]) {
                $user = new User();
                $reponse = $user->changePassword($_SESSION['login'], $_POST['old_password'], $_POST["new_password"]);
                if($reponse) {
                    $_SESSION['message'] = 'Mot de passe modifié';
                    UserController::logout();
                    
                } else {
                    $_SESSION['message'] =  'Le mot de passe n\'est pas bon';
                    UserController::account();
                }
            } else {
                    $_SESSION['message'] =  'Les mots de passe ne sont pas bon';
                    UserController::account();
            }
        } else {
            $view_name = "Views/Error/404.php";
            require_once "Views/Shared/layout.php";
        }
        return;
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

    public static function passwordNotForgotten(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $user = new User();
            $user->forgotPassword($_POST["email"]);
        } else {
            $view_name = "Views/Error/404.php";
            require_once "Views/Shared/layout.php";
        }
    }

    public static function changePasswordForgotten(){
        if($_POST["password"] == $_POST["password_confirm"]) {
            if($_SERVER["REQUEST_METHOD"] == "POST" && !empty( $_SESSION["token"])) {
                $user = new User();
                $ok = $user->passwordfound($_SESSION["token"], $_POST['password']);
                if($ok > 0){
                    $_SESSION['message'] =  'Mots de passe modifié';
                    UserController::index();
                }
            } else {
                $view_name = "Views/Error/404.php";
                require_once "Views/Shared/layout.php";
            }
        } else {
            $_SESSION['message'] =  'Les mots de passe ne sont pas bon';
            UserController::newPassword();
        }
    }
}