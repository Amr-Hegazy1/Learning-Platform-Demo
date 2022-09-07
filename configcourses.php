<?php
    $user = 'root';
    $pass = '';
    $dbc = 'outer';
    $dbc = new mysqli('127.0.0.1:3308', $user, $pass, $dbc) or die("Error");
?>