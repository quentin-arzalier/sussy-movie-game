<?php
// Configuration
require_once 'Config/dbconfig.php';
require_once 'Config/apiconfig.php';
require_once 'Config/hashconfig.php';

header('Content-type: text/html; charset=utf-8');
mb_internal_encoding('UTF-8');
// Helpers
require_once "Helpers/Functions.php";

// Models
include_once 'Models/CRUDAble.php';
include_once 'Models/Movie.php';
include_once 'Models/User.php';
include_once 'Models/Actor.php';
include_once 'Models/Genre.php';
include_once 'Models/Director.php';
include_once 'Models/MovieName.php';
include_once 'Models/UserMovieHistory.php';

// router
require_once 'router.php';