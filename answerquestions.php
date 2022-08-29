<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Answer Questions</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<?php   
        $li = false;
        session_start();
        if(isset($_SESSION['assistantloggedin'])){
            $li = $_SESSION['assistantloggedin'];}
        $assistant = $_SESSION['assistant'];
        if($li){ 
            include_once("nav-assistant.html");
            include "configusers.php";
            $answersql = "SELECT * FROM questions WHERE `Answered`= 0 ORDER BY QuestionID ASC LIMIT 1";
            $res = mysqli_query($db, $answersql);
            if(mysqli_num_rows($res)>0){
                echo "<div class='all-quest qa-change'>";
                while ($question = mysqli_fetch_assoc($res)){
                    echo "<div class='qa-cont'>";

                    echo "<div class='question'><span class='quest-title'>".$question['User']. ": </span>";
                    $ques = $question['Question'];
                    echo $ques;
                    echo "</div>"; 
                    $id = $question['QuestionID'];
                ?>
                    <form method="POST" enctype="multipart/form-data">
                    <div class="name">Answer</div>
                        <div class="text-field">
                            <input type="text" required name="answer" placeholder="Enter New Answer">
                            <span></span>
                        </div>
                        <input type="submit" name='submit' value="Submit" class="submit qsubmit">
                    </form>
                    </div>
                <?php 
                    if(isset($_POST['submit'])){
                        $ans = $_POST['answer'];
                        if(validName($ans)){
                            $submitanswersql = "UPDATE questions SET `Answer`='$ans', `Assistant`= '$assistant', `Answered`=1 WHERE `QuestionID` = '$id'";
                            if(!mysqli_query($db, $submitanswersql)){
                                echo "<div class='pop-up qa-change-pop'>Error</div>";
                            } else {
                                echo "<div class='pop-up qa-change-pop'>Answer Submitted</div>";
                                header("Refresh:1");
                            }
                        } else {echo "<div class='pop-up'>You cannot submit an empty answer</div>";}
                    }           
                }
            } else {
                echo "<div class='pop-up'>No Questions Yet</div>";
            }
        }else{
            echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';;
        }

        function validName($name){
            if(strlen($name)>0){
                return true;
            }
            return false;
        }
?>
</body>
</html>