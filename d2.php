<?php 
 try{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include "configcourses.php";
    //echo "This is d2";
    $_SESSION['selected'] = "d2";
    include "indexeach.php";
}catch( Error $ex){
    echo $ex;
}catch(Exception $ex){
    echo $ex;
}
?>