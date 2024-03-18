<?php
session_start();
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
$admin_offset = 0;

if ($count > 1 && $url_parts[1] == "admin")
{
    if (key_exists('is_admin', $_SESSION) && $_SESSION['is_admin'])
    {
        $admin_offset = 1;
    }
    else {
        // TODO : Voir si not found ou si unauthorized
        goto not_found;
    }
}

if ($count > 1 + $admin_offset && strlen($url_parts[1 + $admin_offset]) > 0)
{
    $controllerName = ucfirst(strtolower($url_parts[1 + $admin_offset])) . "Controller";
}
if ($count > 2 + $admin_offset && strlen($url_parts[2 + $admin_offset]) > 0)
{
    $action = strtolower($url_parts[2 + $admin_offset]);
}

$path_array = array("Controllers", $controllerName . ".php");
if ($admin_offset == 1)
    array_splice($path_array, 1, 0, "Admin");

$file_path = get_file_path($path_array);

if (file_exists($file_path))
    include_once $file_path;

if (class_exists($controllerName) && method_exists($controllerName, $action))
{
    $controllerName::$action();
}
else {
    not_found:
    http_response_code(404);
    $view_name = "Views/Error/404.php";
    if (isset($admin_offset) && $admin_offset == 1)
    {
        require_once "Views/Shared/admin_layout.php";
    }
    else
    {
        require_once "Views/Shared/layout.php";
    }
}
