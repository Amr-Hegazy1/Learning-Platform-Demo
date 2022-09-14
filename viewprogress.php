<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Progress</title>
    <link rel="stylesheet" href="styles/styles.css">


    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
</head>
<body>
    <?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){
            include_once("nav.html");
            include "configeach.php";
            $getall =  $db->query("SELECT * FROM `work`");
            while($rows = $getall->fetch_assoc()){
                $aid = $rows['AssignmentID'];
                $uid = $rows['UserID'];
                $grade = $rows['Grade'];
                $mg = 100;
                $getmg = $db->query("SELECT `MaxGrade` FROM `assignments` WHERE `AssignmentID` = '$aid' LIMIT 1");
                while($row = $getmg->fetch_assoc()){
                    $mg = $row['MaxGrade'];
                }
                $per = (($grade / $mg)*100);
                $insert = $db->query("UPDATE `progress` SET `$aid` = '$per' WHERE `UserID` = '$uid'");
            }
            $out = '<div class="table-cont">
            <table class="table" id="TableToExport"><thead><tr>';
            $arr = getArray($db);
            $count = count($arr);
            $out .="<th>User</th>";
            for($i = 0; $i<$count; $i++){
                $out .="<th>$arr[$i]</th>";
            }
            $out .="</tr></thead><tbody>";
            $fetch = $db->query("SELECT * FROM `progress`");
            while($each = $fetch->fetch_assoc()){
                $out .="<tr>";
                $useridstring = 'UserID';
                $out .="<td>$each[$useridstring]</td>";
                for($i = 0; $i<$count; $i++){
                    $ass = $arr[$i];
                    $out .="<td>$each[$ass]</td>";
                }
                $out .="</tr>";
            }
            $out .="</tbody></table></div>";
            echo "$out";
            displayAssignmentDetails($db);
            ?>
                <input name="export" value="Download" class="submit" id="sheetjsexport">
            <?php



            $a1 = array("UserID");
            $arrup = array_merge($a1, $arr);
        }else{
            echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';;}
        function getArray($db){
            $all = $db->query("SELECT `AssignmentID` FROM `assignments`");
            $return = [];
            while($x = $all->fetch_assoc()){
                $y = $x['AssignmentID'];
                array_push($return, $y);
                //print_r($return); 
                //echo "<br>";
            }
            return $return;
        }
        function displayAssignmentDetails($db){
            $all = $db->query("SELECT * FROM `assignments`");
            echo "<div class='all-quest'>";
            echo "<div class='qa-cont'>";
            while($x = $all->fetch_assoc()){
                echo $x['AssignmentID']." : ";
                echo $x['Description']."<br>";
            }
            echo "</div>";     
            echo "</div>";   
        }


    ?>
    <script>
        document.getElementById("sheetjsexport").addEventListener('click', function() {
        /* Create worksheet from HTML DOM TABLE */
        var wb = XLSX.utils.table_to_book(document.getElementById("TableToExport"));
        /* Export to file (start a download) */
        XLSX.writeFile(wb, "report.xlsx");
        });
</script>
</body>
</html>