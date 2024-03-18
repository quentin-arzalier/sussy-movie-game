<?php

class HomeController
{
    public static function index()
    {
        $view_name = "Views/Admin/Home/index.php";
        require_once "Views/Admin/Shared/admin_layout.php";
    }
}