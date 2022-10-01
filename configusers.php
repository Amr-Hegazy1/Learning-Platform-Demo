<?php
 try{
    $user = 'root';
    $pass = '';
    $db = 'users';
    $db = new mysqli('127.0.0.1:3306', $user, $pass, $db) or die("Error");
/*
    echo("Connected Successfully<br>")*/
}catch( Error $ex){
    echo $ex;
}catch(Exception $ex){
    echo $ex;
}
?>