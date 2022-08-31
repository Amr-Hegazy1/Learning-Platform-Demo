<?php 
session_start();
$_SESSION['adminloggedin'] = false;
$_SESSION['assistantloggedin'] = false;
$_SESSION['loggedin'] = false;
header("Refresh:1, url=index.php");
?>