<?php 
 try{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include "configcourses.php";
    //echo "This is d4";
    $_SESSION['selected'] = "d4";
    include "indexeach.php";
}catch( Error $ex){
    echo $ex;
}catch(Exception $ex){
    echo $ex;
}
?>