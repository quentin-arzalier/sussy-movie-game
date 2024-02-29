<?php
// Configuration
require_once 'Config/dbconfig.php';
require_once 'Config/apiconfig.php';

// Controllers
require_once "Controllers/HomeController.php";
include_once "Controllers/MovieController.php";
include_once "Controllers/ApiController.php";

// Models
include 'Models/CRUDAble.php';
include_once 'Models/Movie.php';
include_once 'Models/MovieName.php';

// router
require_once 'router.php';