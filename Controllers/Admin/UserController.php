<?php
Class UserController
{
    public static function index(){
        // if($_SESSION['is_admin']){
        //     $user = new User();
        //     $users = $user->getAllUsers();
        //     $view_name = "Views/User/admin.php";
        //     require_once "Views/Shared/layout.php";
        // } else {
        //     $view_name = "Views/Error/404.php";
        //     require_once "Views/Shared/layout.php";
        // }
        $user = new User();
        $users = $user->getAllUsers();
        $view_name = "Views/Admin/User/index.php";
        require_once "Views/Admin/Shared/admin_layout.php";
    }

    public static function updateAdmin(){
        //echo "coucou";
        if($_SESSION["is_admin"] && $_SERVER["REQUEST_METHOD"] == "POST"){
            $username = $_POST["username"];
            $user = new User();
            $user->updateAdmin($username);
        } else {
            $view_name = "Views/Error/404.php";
            require_once "Views/Shared/layout.php";
        }
}

    public static function deleteUser(){
        if($_SESSION["is_admin"] && $_SERVER["REQUEST_METHOD"] == "POST"){
            $username = $_POST["username"];
            $user = new User();
            $user->deleteUser($username);
        } else {
            $view_name = "Views/Error/404.php";
            require_once "Views/Shared/layout.php";
        }
    }
}