<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Returns</title>
    <link rel="stylesheet" href="./styles/styles.css">

</head>
<body>
    <?php
        $li = false;
        if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
        if(isset($_SESSION['loggedin'])){
            $li = $_SESSION['loggedin'];}
        if($li){
            include_once("nav-user.html");
            $u = $_SESSION['username'];
            include "configeach.php";
            $viewsql = "SELECT * FROM `work` WHERE `UserID`='$u' AND `Corrected` = 1 ORDER BY `AssignmentID` DESC";
            $res = mysqli_query($db, $viewsql);
            $resultCheck = mysqli_num_rows($res);
            if($resultCheck>0){
                echo "<h1 class='table-title'>Assignments Returned</h1>";
                $out = '<div class="table-cont">
                <table class="table"><thead><tr>'; 
                $out .="<th>Assignment ID</th><th>Grade</th><th>Comments</th><th>Corrected By</th><th>File</th></tr></thead><tbody>";
                while ($row = mysqli_fetch_assoc($res)){
                    $out .="<tr><td>".$row['AssignmentID']."</td>";
                    $out .= "<td>".$row['Grade'].getMaxGrade($db, $row['WorkID'])."</td>";
                    $out .= "<td>".$row['Comments']."</td>";
                    $out .= "<td>".$row['AssistantID']."</td>";

                    $out .='<td><a href="./'.changeName($row['WorkFile']).'"><button class="viewbtn">View</button></a></td></tr>';
                }
                $out .="</tbody></table></div>";
                echo $out;
            } else {
                echo "<div class='pop-up'>No Assignments returned yet</div>";
            }
            $respondsql = "SELECT * FROM questions WHERE `User` = '$u' AND (`Answered` = 1 OR `TeacherAnswered` = 1) ORDER BY `QuestionID` DESC";
            $qres = mysqli_query($db, $respondsql);
            $countCheck = mysqli_num_rows($qres);
            if($countCheck>0){
                echo "<h1 class='table-title'>Questions Answered</h1>";
                echo "<div class='all-quest'>";
                while ($ques = mysqli_fetch_assoc($qres)){
                    echo "<div class='qa-cont'>";
                    echo "<div class='question'><span class='quest-title'>Question ".$ques['QuestionID'].": </span>";                    
                    echo $ques['Question'];
                    echo "</div>"; 

                    echo "<div class='answer-teacher'><span class='answer-teacher-title'>Teacher's Answer: </span>";
                    echo $ques['TeacherAnswer']; 
                    echo "</div>";  

                    echo "<div class='answer-assistant'><span class='answer-assistant-title'>Assistant's Answer: </span>";
                    echo $ques['Answer'];
                    echo " ~ ".$ques['Assistant'];
                    echo "</div>";   
                    echo "</div>"; 
                }
                echo "</div>";  
                echo "</div>";  

            } else {echo "<div class='pop-up'>No Questions answered yet</div>";}
        }else{
            echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';;
        }

        function changeName($n){
            $return = "returns".substr($n,4);
            return $return;
        }

        function getMaxGrade($db, $id){
            $sql = $db->query("SELECT `AssignmentID` FROM `work` WHERE `WorkID`='$id' LIMIT 1");
            if($row = $sql->fetch_assoc()){
                $aid = $row['AssignmentID'];
            }
            $sql2 = $db->query("SELECT `MaxGrade` FROM `assignments` WHERE `AssignmentID`='$aid'");
            if($x = $sql2->fetch_assoc()){
                $y = $x['MaxGrade'];
            }
            return "/$y";
        }
    ?>
</body>
</html>