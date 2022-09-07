<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Progress</title>
    <link rel="stylesheet" href="http://localhost/TCD/styles.css">

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
            $out = '<table class="table"><thead><tr>';
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

            $out .="</tbody></table>";

            echo "$out";
            displayAssignmentDetails($db);
            ?>
            <form method="POST" enctype="multipart/form-data">
                <input type="submit" name="export" value="Download" class="submit">
            </form>
            <?php
            if(isset($_POST["export"])){
                header('Content-Type: application/xls');
                header('Content-Disposition: attachment; filename=report.xls');
                header("Refresh:1");
            }


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
</body>
</html>