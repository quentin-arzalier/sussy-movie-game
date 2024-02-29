<?php
// Configuration
require_once 'Config/dbconfig.php';
require_once 'Config/apiconfig.php';
require_once 'Config/hashconfig.php';


// Controllers
require_once "Controllers/HomeController.php";
include_once "Controllers/MovieController.php";
include_once "Controllers/ApiController.php";
include_once "Controllers/UserController.php";

// Models
include_once 'Models/Movie.php';
include_once 'Models/CRUDAble.php';
include_once 'Models/User.php';

// router
require_once 'router.php';