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
                echo "<h4>Assignments Returned</h4>";
                while ($row = mysqli_fetch_assoc($res)){
                    echo "Assignment ID: ".$row['AssignmentID']." - ";
                    echo "Grade: ".$row['Grade']." - ";
                    echo "Comments: ".$row ['Comments']." - Corrected by: ".$row['AssistantID']." - ";
                    echo '<a href="https://localhost/TCD/'.changeName($row['WorkFile']).'">View</a>.<br><br>';
                }
            } else {
                echo "No Assignments returned yet";
            }
            $respondsql = "SELECT * FROM questions WHERE `User` = '$u' AND (`Answered` = 1 OR `TeacherAnswered` = 1) ORDER BY `QuestionID` DESC";
            $qres = mysqli_query($db, $respondsql);
            $countCheck = mysqli_num_rows($qres);
            if($countCheck>0){
                echo "<h4>Questions Answered</h4>";
                while ($ques = mysqli_fetch_assoc($qres)){
                    echo "Question ".$ques['QuestionID']." : ";
                    echo $ques['Question'];
                    echo "<br>";
                    echo "Answer: ";
                    echo $ques['Answer'];
                    echo " ~ ".$ques['Assistant'];
                    echo "<br>";
                    echo "Teacher's Answer: ";
                    echo $ques['TeacherAnswer']; 
                    echo "<br>";
                    echo "<br>";
                }
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