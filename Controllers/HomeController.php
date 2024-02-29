<?php

class HomeController
{
    public static function index()
    {
        $view_name = "Views/Home/index.php";
        require_once "Views/Shared/layout.php";
    }
}