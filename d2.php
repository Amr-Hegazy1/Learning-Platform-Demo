<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "configcourses.php";
//echo "This is d2";
$_SESSION['selected'] = "d2";
include "indexeach.php";
?>