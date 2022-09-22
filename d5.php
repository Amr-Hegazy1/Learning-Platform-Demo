<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "configcourses.php";
//echo "This is d5";
$_SESSION['selected'] = "d5";
include "indexeach.php";
?>