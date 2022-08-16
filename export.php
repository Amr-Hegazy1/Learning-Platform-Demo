<?php 
if(isset($_POST["export"])){
    include "configusers.php";
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, $arrup);
    $newest = $db->query("SELECT * FROM `progress`");
    while($thisresult = $newest->fetch_assoc()){
        fputcsv($output, $thisresult);
    }
    fclose($output);
}
?>