<?php 
 try{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['adminloggedin'] = false;
    $_SESSION['assistantloggedin'] = false;
    $_SESSION['loggedin'] = false;
    $_SESSION['manager'] = false;
    $_SESSION['selected'] = "";
    header("Refresh:1, url=index.php");
}catch( Error $ex){
    echo $ex;
}catch(Exception $ex){
    echo $ex;
}
?>