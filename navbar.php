<?php
session_start();
if(isset($_SESSION['loggedin'])){$u = $_SESSION['loggedin'];}
if(isset($_SESSION['assistantloggedin'])){$as = $_SESSION['assistantloggedin'];}
if(isset($_SESSION['adminloggedin'])){$ad = $_SESSION['adminloggedin'];}
if($u){}elseif($as){}elseif($ad){}
 ?>
