<?php

    $file =  base64_decode($_POST['file']);
    if(!is_dir("../returns/".$_POST["selected"]))
        mkdir("../returns/".$_POST["selected"]);
    file_put_contents( "../returns/".$_POST["fileName"], $file);
    
    


?>