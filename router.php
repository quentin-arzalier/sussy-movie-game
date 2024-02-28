<?php
include 'Models/Movie.php';

$mov = new Movie();
var_dump($mov->getAllMovies());