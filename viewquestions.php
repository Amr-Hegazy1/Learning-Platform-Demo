<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Questions</title>
</head>
<body>
<?php
    $li = false;
    session_start();
    if(isset($_SESSION['loggedin'])){
        $li = $_SESSION['loggedin'];}
    if($li){
        include "configusers.php";
        $viewqssql = "SELECT * FROM questions WHERE Answered = 1 ORDER BY QuestionID DESC";
        $res = mysqli_query($db, $viewqssql);
        $resultCheck = mysqli_num_rows($res);
        if($resultCheck>0){
            while ($row = mysqli_fetch_assoc($res)){
                echo "Question ".$row['QuestionID']." : ";
                echo $row['Question'];
                echo " ~ ".$row['User'];                
                echo "<br>";
                echo "Answer: ";
                echo $row['Answer'];
                echo " ~ ".$row['Assistant'];
                echo "<br>";
                echo "Teacher's Answer: ";
                echo $row['TeacherAnswer']; 
                echo "<br>";
                echo "<br>";           
            }
        } else {
            echo "Empty";
        }
    }else{
        echo "Access denied";
    }
?>
</body>
</html>