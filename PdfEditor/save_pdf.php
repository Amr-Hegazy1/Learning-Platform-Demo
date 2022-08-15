<?php
if (isset($_POST['file'])){
    $file =  base64_decode($_POST['file']);
    file_put_contents( "out.pdf", $file );
    
}

?>