<?php 
session_start();
include "configcourses.php";
//echo "This is d1";
$_SESSION['selected'] = "d1";
include "indexeach.php";
?>