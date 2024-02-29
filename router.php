<?php

$url = explode("?", $_SERVER['REQUEST_URI'])[0];

// Pour transformer les /////controller///////action en /controller/action
while (str_contains($url, "//"))
{
    $url = str_replace("//", "/", $url);
}

$url_parts = explode("/", $url);

$count = count($url_parts);

// Valeurs par défaut si jamais il manque des valeurs de route
$controllerName = "HomeController";
$action = "index";

if (count($url_parts) > 1 && strlen($url_parts[1]) > 0)
{
    $controllerName = ucfirst(strtolower($url_parts[1])) . "Controller";
}
if (count($url_parts) > 2 && strlen($url_parts[2]) > 0)
{
    $action = strtolower($url_parts[2]);
}

if (class_exists($controllerName) && method_exists($controllerName, $action))
{
    $controllerName::$action();
}
else {
    http_response_code(404);
    $view_name = "Views/Error/404.php";
    require_once "Views/Shared/layout.php";
}
