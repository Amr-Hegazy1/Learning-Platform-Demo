<?php
header('Content-Type: application/pdf');

$fileContents =  readfile("../".$_GET['workFile']);
echo $fileContents;
?>