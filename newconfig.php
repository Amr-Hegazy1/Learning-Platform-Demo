<?php
    $user = 'root';
    $pass = '';
    $db = 'tcd';
    $db = new mysqli('127.0.0.1:3308', $user, $pass, $db) or die("Error");

    echo("Connected Successfully<br><br>")
?>