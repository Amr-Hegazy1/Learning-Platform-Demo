<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Questions</title>
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
        echo "<h1>Questions</h1><hr>";
        include "configusers.php";
        ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="name">Question</div>
                <div class="text-field">
                    <input type="text" required name="question" placeholder="Enter Question">
                    <span></span>
                </div>
                <input type="submit" name='submit' value="Submit" class="submit qsubmit">
        </form>
            </div>
<?php
        if(isset($_POST['submit'])){
            $user = $_SESSION['username'];
            $question = $_POST['question'];
            if(validName($question)){
                $asksql = "INSERT INTO questions(`User`, `Question`)VALUES('$user', '$question')";
                if(!mysqli_query($db, $asksql)){
                    echo "<div class='pop-up'>Error</div>";
                } else {
                    echo "<div class='pop-up'>Question Submitted</div>";
                }
            } else {echo "<div class='pop-up'>Cannot submit empty question</div>";}
        }
        $viewqssql = "SELECT * FROM questions WHERE (`Answered` = 1 OR `TeacherAnswered` = 1) ORDER BY QuestionID DESC";
        $res = mysqli_query($db, $viewqssql);
        $resultCheck = mysqli_num_rows($res);
        if($resultCheck>0){
            while ($row = mysqli_fetch_assoc($res)){
                echo "Question ".$row['QuestionID']." : ";
                echo $row['Question'];
                echo " ~ ".$row['User'];                
                echo "<br>";
                echo "Assistant's Answer: ";
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
            echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';;
    }

    function validName($name){
        if(strlen($name)>5){
            return true;
        }
        return false;
    }
?>
</body>
</html>