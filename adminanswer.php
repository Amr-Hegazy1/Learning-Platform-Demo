<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Answer Questions</title>
</head>
<body>
<?php 
        include "configusers.php";
        $li = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $li = $_SESSION['adminloggedin'];}
        $admin = $_SESSION['admin'];
        if($li){ 
            $answersql = "SELECT * FROM questions WHERE `TeacherAnswered`= 0 ORDER BY QuestionID ASC LIMIT 1";
            $res = mysqli_query($db, $answersql);
            if(mysqli_num_rows($res)>0){
                while ($question = mysqli_fetch_assoc($res)){
                    echo $question['User']." : ";
                    echo $question['Question']." : ";
                    $id = $question['QuestionID'];
                    echo $question['Assistant']." : ";
                    echo $question['Answer']." : ";
                    ?>
                        <form method="POST" enctype="multipart/form-data">
                            Admin's Answer: <input type="text" name="answer">
                            <input type="submit" name='submit' value="Submit">
                        </form>
                    <?php 
                    if(isset($_POST['submit'])){
                        $ans = $_POST['answer'];
                        $submitadminanswersql = "UPDATE `questions` SET `TeacherAnswer` = '$ans', `TeacherAnswered` = 1 WHERE `QuestionID` = '$id'";
                        if(!mysqli_query($db, $submitadminanswersql)){
                            echo "<br><h2>Error :(</h2>";
                        } else {
                            echo "<br><h2>Answer Submitted</h2>";
                        }
                    }           
                }
            } else {
                echo "No Questions Yet";
            }
        }else{
            echo "Access Denied";
        }
?>
</body>
</html>