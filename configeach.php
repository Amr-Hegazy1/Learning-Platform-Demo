<?php
    $selected = $_SESSION['selected'];
    $user = 'root';
    $pass = '';
    $db = $selected;
    $db = new mysqli('127.0.0.1:3308', $user, $pass, $db) or die("Error");
    /*echo "<h1>".getTitle($db, $selected)."</h1>";*/

    function getTitle($db, $selected){
        include "configcourses.php";
        $sql = $dbc->query("SELECT `Title` FROM `courses` WHERE `D`='$selected'");
        while($row = $sql->fetch_assoc()){
            if($row['D'] = $selected){
                return $row['Title'];
            }
        }
    }
?>