<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Progress</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="submit" name="export" value="Download">
    </form>
    <?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){
            include "configusers.php";
            $getall =  $db->query("SELECT * FROM `work`");
            while($rows = $getall->fetch_assoc()){
                $aid = $rows['AssignmentID'];
                $uid = $rows['UserID'];
                $grade = $rows['Grade'];
                $getmg = $db->query("SELECT `MaxGrade` FROM `assignments` WHERE `AssignmentID` = '$aid' LIMIT 1");
                while($row = $getmg->fetch_assoc()){
                    $mg = $row['MaxGrade'];
                }
                $per = (($grade / $mg)*100);
                $insert = $db->query("UPDATE `progress` SET `$aid` = '$per' WHERE `UserID` = '$uid'");
            }
            $out = '<table class="table" border="1"><thead><tr>';
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
            $out .="</tbody>";

            echo "$out";
            displayAssignmentDetails($db);


            $a1 = array("UserID");
            $arrup = array_merge($a1, $arr);
            if(isset($_POST["export"])){
                header('Content-Type: application/xls');
                header('Content-Disposition: attachment; filename=report.xls');
            }


        }else{echo "Access Denied";}


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
            while($x = $all->fetch_assoc()){
                echo $x['AssignmentID']." : ";
                echo $x['Description']."<br>";
            }
        }


    ?>
</body>
</html>