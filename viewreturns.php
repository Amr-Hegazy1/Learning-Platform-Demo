<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Returns</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <?php include_once("nav-user.html"); ?>
    <?php
        $li = false;
        session_start();
        if(isset($_SESSION['loggedin'])){
            $li = $_SESSION['loggedin'];}
        if($li){
            $u = $_SESSION['username'];
            include "configusers.php";
            $viewsql = "SELECT * FROM work WHERE `UserID`='$u' AND `Corrected` = 1 ORDER BY `AssignmentID` DESC";
            $res = mysqli_query($db, $viewsql);
            $resultCheck = mysqli_num_rows($res);
            if($resultCheck>0){
                echo "<h1 class='table-title'>Assignments Returned</h1><hr>";
                $out = '<div class="table-cont">
                <table class="table"><thead><tr>'; 
                $out .="<th>Assignment ID</th><th>Grade</th><th>Comments</th><th>Corrected By</th><th>File</th></tr></thead><tbody>";
                while ($row = mysqli_fetch_assoc($res)){
                    $out .="<tr><td>".$row['AssignmentID']."</td>";
                    $out .= "<td>".$row['Grade']."</td>";
                    $out .= "<td>".$row['Comments']."</td>";
                    $out .= "<td>".$row['AssistantID']."</td>";
                    //$out .= "<td><a href='https://localhost/TCD/".changeName($row['WorkFile']).">View</a></td></tr>";
                }
                $out .="</tbody></table></td></div>";
                echo $out;
            } else {
                echo "No Assignments returned yet";
            }
            $respondsql = "SELECT * FROM questions WHERE `User` = '$u' AND (`Answered` = 1 OR `TeacherAnswered` = 1) ORDER BY `QuestionID` DESC";
            $qres = mysqli_query($db, $respondsql);
            $countCheck = mysqli_num_rows($qres);
            if($countCheck>0){
                echo "<h1 class='table-title'>Questions Answered</h1><hr>";
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
                    echo "</div>";   
                    echo "</div>"; 
                }
                echo "</div>";
                echo "</div>";  
            }
        }else{
                        echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';;
        }
        function changeName($n){
            $return = "returns".substr($n,4);
            echo $return;
            return $return;
        }
    ?>
</body>
</html>