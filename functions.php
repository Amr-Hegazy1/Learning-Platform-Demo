<?php
    function checkAssistantLogin($user, $pass){
        include "configusers.php";
        $assistantloginsql = "SELECT AssistantPassword FROM assistants WHERE AssistantUsername = '$user' ";
        $res = mysqli_query($db, $assistantloginsql);
        $resultCheck = mysqli_num_rows($res);
        $row = mysqli_fetch_assoc($res);
        echo "$resultCheck";
        if($resultCheck>0){
            if(password_verify($pass, $row['AssistantPassword'])){
                echo "Password Correct";
                return true;
            } else {
                echo "Incorrect Username or Password";
                return false;
            }
        }
    }
?>