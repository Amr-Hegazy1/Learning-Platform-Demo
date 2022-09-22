<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "configcourses.php";
//echo "This is d3";
$_SESSION['selected'] = "d3";
include "indexeach.php";
?>