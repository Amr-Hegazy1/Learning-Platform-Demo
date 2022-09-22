<?php

    $file =  base64_decode($_POST['file']);
    if(!is_dir("../returns/"))
    file_put_contents( "../returns/".$_POST["fileName"], $file);
    


?>