<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Returns</title>
    <link rel="stylesheet" href="http://localhost/TCD/styles.css">

</head>
<body>
    <?php
        $li = false;
        session_start();
        if(isset($_SESSION['loggedin'])){
            $li = $_SESSION['loggedin'];}
        if($li){
            include_once("nav-user.html");
            $u = $_SESSION['username'];
            include "configeach.php";
            $viewsql = "SELECT * FROM work WHERE `UserID`='$u' AND `Corrected` = 1 ORDER BY `AssignmentID` DESC";
            $res = mysqli_query($db, $viewsql);
            $resultCheck = mysqli_num_rows($res);
            if($resultCheck>0){
                echo "<h3>Assignments Returned</h3>";
                echo "<div class='all-quest qa-change'>";
                while ($row = mysqli_fetch_assoc($res)){
                    echo "<div class='qa-cont'>";

                    echo "<div class='answer-teacher'><span class='answer-teacher-title'>Assignment ID:</span> ".$row['AssignmentID']."</div>";
                    echo "<div class='question'><span class='quest-title'>Grade: </span>".$row['Grade']."</div>";
                    echo "<div class='answer-teacher'><span class='answer-teacher-title'>Comments: </span>".$row ['Comments']."</div>";
                    echo "<div class='answer-teacher'><span class='answer-teacher-title'>Corrected by: </span>".$row['AssistantID']."</div>";
                    echo '<a href="https://localhost/TCD/'.changeName($row['WorkFile']).'">View</a><br><br>';
                    echo "</div>";  

                }
                echo "</div>";  

            } else {
                echo "<div class='pop-up'>No Assignments returned yet</div>";
            }
            $respondsql = "SELECT * FROM questions WHERE `User` = '$u' AND (`Answered` = 1 OR `TeacherAnswered` = 1) ORDER BY `QuestionID` DESC";
            $qres = mysqli_query($db, $respondsql);
            $countCheck = mysqli_num_rows($qres);
            if($countCheck>0){
                echo "<h3>Questions Answered</h3>";
                echo "<div class='all-quest qa-change'>";
                while ($ques = mysqli_fetch_assoc($qres)){
                    echo "<div class='qa-cont'>";

                    echo "<div class='question'><span class='quest-title'>Question ".$ques['QuestionID']." : </span>";
                    echo $ques['Question'];
                    echo " ~ ".$ques['User'];                
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
            } else {echo "<div class='pop-up'>No Questions answered yet</div>";}
        }else{
            echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';;
        }
        function changeName($n){
            $return = "returns".substr($n,4);
            return $return;
        }
    ?>
</body>
</html>