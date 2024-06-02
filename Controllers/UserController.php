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

    public static function history(){
        if(empty($_SESSION['login'])){
            $view_name = "Views/Error/404.php";
            require_once "Views/Shared/layout.php";
            return;
        }

        $query_obj = new UserMovieHistory();
        $total_histories = $query_obj->countAllHistories($_SESSION['login']);

        if ($total_histories == 0)
        {
            $view_name = "Views/User/empty_history.php";
            require_once "Views/Shared/layout.php";
            $view_name = get_file_path(array("Views", "User", "empty_history.php"));
            require_once get_file_path(array("Views", "Shared", "layout.php"));
            return;
        }



        $curr_page = 1;
        if (isset($_GET["page"]) && is_numeric($_GET["page"]) && (int)$_GET["page"] > 0)
        {
            $curr_page = (int)$_GET["page"];
        }

        $date_param = null;
        if (isset($_GET["date"]))
        {
            $date_param = $_GET["date"];
        }

        $page_size = UserMovieHistory::PAGE_SIZE;

        $max_page = (int)ceil($total_histories / $page_size);

        if ($curr_page > $max_page)
            $curr_page = $max_page;

        $histories = $query_obj->getHistoriesPaginated($_SESSION["login"], $curr_page - 1);


        if (count($histories) == 0 && $curr_page != 1)
        {
            $curr_page = 1;
            $histories = $query_obj->getHistoriesPaginated($_SESSION["login"], $curr_page - 1);
        }

        $active_history = $histories[0];

        if ($date_param != null)
        {
            $active_history = $query_obj->getByDate($_SESSION["login"], $date_param);
            if ($active_history == null)
                $active_history = $histories[0];
        }

        $view_name = get_file_path(array("Views", "User", "history.php"));
        require_once get_file_path(array("Views", "Shared", "layout.php"));
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
                $_SESSION['errorMessage'] = 'Les mots de passe ne correspondent pas';
                UserController::createpage();
                return;
            }
            
            $user = new User();
            $rep = $user->newUser($_POST['username'],$_POST['email'],$_POST['password']);
            if($rep){
                $_SESSION['message'] = 'Veuillez vérifier votre mail';
                UserController::index();
            } else {
                $_SESSION['errorMessage'] = 'Erreur veuillez réessayer';
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
                $_SESSION['errorMessage'] = "Votre nom d'utilisateur et/ou votre mot de passe est incorrect et/ou votre mail n'est pas vérifié";
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
                $_SESSION['errorMessage'] = "Problème lors de la vérification";
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
                    $_SESSION['errorMessage'] =  'Le mot de passe n\'est pas bon';
                    UserController::account();
                }
            } else {
                    $_SESSION['errorMessage'] =  'Les mots de passe ne sont pas bon';
                    UserController::account();
            }
        } else {
            $view_name = "Views/Error/404.php";
            require_once "Views/Shared/layout.php";
        }
        return;
    }

    public static function logout(){
        foreach (array_keys($_SESSION) as $array_key) {
            if ($array_key != 'message')
                unset($_SESSION[$array_key]);
        }
        session_destroy();
        UserController::index();
    }
    public static function account(){
        if(empty($_SESSION['login'])){
            $view_name = "Views/Error/404.php";
            require_once "Views/Shared/layout.php";
            return;
        }

        $view_name = "Views/User/account.php";
        require_once "Views/Shared/layout.php";
    }

    public static function loginToContinue()
    {
        $view_name = "Views/User/loginToContinue.php";
        require_once "Views/Shared/layout.php";
    }

    public static function passwordForgotten(){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $user = new User();
            if (!$user->forgotPassword($_POST["email"]))
            {
                http_response_code(400);
            }
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
                    $_SESSION['message'] =  'Mot de passe modifié';
                    UserController::index();
                }
            } else {
                $view_name = "Views/Error/404.php";
                require_once "Views/Shared/layout.php";
            }
        } else {
            $_SESSION['errorMessage'] =  'Les mots de passe ne sont pas bon';
            UserController::newPassword();
        }
    }

    public static function setCountryCode()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST")
        {
            http_response_code(404); // Not Found
            return;
        }
        if (!isset($_SESSION["login"]))
        {
            http_response_code(401); // Unauthorized
            return;
        }
        if (!isset($_POST["country_code"]) || strlen($_POST["country_code"]) != 2)
        {
            http_response_code(400); // Bad Request
            return;
        }
        $user = (new User())->getByUserName($_SESSION["login"]);
        $user->setCountryCode(strtoupper($_POST["country_code"]));
        $user->update();
    }
}