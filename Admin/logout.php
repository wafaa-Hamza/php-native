<?php 

session_start(); 
require './helpers/functions.php';

session_destroy();

header("location: ".url('login.php'));


?>