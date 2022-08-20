<?php

    $file =  base64_decode($_POST['file']);
    
    file_put_contents( "../returns/".$_POST["fileName"], $file);
    


?>