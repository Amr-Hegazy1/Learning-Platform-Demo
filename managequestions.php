<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Questions</title>
    <link rel="stylesheet" href="http://localhost/Outershell/styles/styles.css">

</head>
<body>
<?php
    $li = false;
    session_start();
    if(isset($_SESSION['adminloggedin'])){
        $li = $_SESSION['adminloggedin'];}
    if($li){
        include_once("nav.html");
        include "configeach.php";
        $answersql = "SELECT * FROM questions WHERE `TeacherAnswered`= 0 ORDER BY QuestionID ASC LIMIT 1";
        $res = mysqli_query($db, $answersql);
        if(mysqli_num_rows($res)>0){
            echo "<h1 class='table-title'>Answer</h1>";
            while ($question = mysqli_fetch_assoc($res)){
                echo "<div class='qa-change admin-ans-cont'>";
                echo "<div class='qa-cont'>";
                echo "<div class='question'><span class='quest-title'>".$question['User']. ": </span>";
                echo $question['Question'];
                echo "</div>";
                $id = $question['QuestionID'];
                ?>

                    <form method="POST" enctype="multipart/form-data">
                    <div class="name">Answer</div>
                        <div class="text-field">
                            <input type="text" required name="answer" placeholder="Enter Your Answer">
                            <span></span>
                        </div>
                        <input type="submit" name='submitanswer' value="Submit" class="submit ">
                    </form>
                    </div>
            </div>
                <?php 
                if(isset($_POST['submitanswer'])){
                    $ans = $_POST['answer'];
                    if(validName($ans)){
                        $submitadminanswersql = "UPDATE `questions` SET `TeacherAnswer` = '$ans', `TeacherAnswered` = 1 WHERE `QuestionID` = '$id'";
                        if(!mysqli_query($db, $submitadminanswersql)){
                            echo "<div class='pop-up'>Error</div>";
                        } else {
                            echo "<div class='pop-up'>Answer Submitted</div>";
                            header("Refresh:1");
                        }
                    }
                }           
            }
        } else {
            echo "<div class='pop-up'>No Questions to be answered</div>";
        }
        $getques = $db->query("SELECT * FROM questions"); //Get available questions
        $getques2 = $db->query("SELECT * FROM questions"); //Get available questions?>
        <div class="container">  
            <div class="segment">
            <h1 class="title">Remove</h1>
            <div class="line"></div>
            <form method="POST" enctype="multipart/form-data">
           <select name='id' id='id' hidden="hidden">
           <?php 
            while($rows = $getques->fetch_assoc()){
                $thisid = $rows['QuestionID'];
                $thisques = $rows['Question'];
                echo "<option value='$thisid'>$thisid : $thisques </option>";
            }
            ?> 
            </select>
                <div class="drop-down" id="drop-down">
                    <div class="name" id="assign-drop">Question Id : <span id="selected-drop"></span></div>
                    <div id="drop-button">▼</div>
                </div>
                <div class="options-cont" id="options">
                    <ul>
                    <?php
                        $getques = $db->query("SELECT * FROM questions");  
                        while($rows = $getques->fetch_assoc()){
                            $thisid = $rows['QuestionID'];
                            $thisques = $rows['Question'];
                            echo "<li class='option'>$thisid</li>";
                        }
                    ?>  
                    </ul>
                </div>
                <div id="exit-drop" class="close"></div>
                <input type="submit" name="removesubmit" value="Remove" class="submit">
            </form>
        </div>
        <?php
        if(isset($_POST['removesubmit']) && isset($_POST['id'])){
            $id = $_POST['id'];
            $removeqsql = "DELETE FROM `questions` WHERE(`QuestionID`= '$id')";
            if(!mysqli_query($db, $removeqsql)){
                echo "<div class='pop-up'>Question not Removed</div>";
            } else {
                echo "<div class='pop-up'>Question Removed!</div>";
                }
        }
        ?>
        <div class="segment">
            <h1 class="title" id="change-ans">Change Answers</h1>
            <div class="line"></div>
            <form method="POST" enctype="multipart/form-data">
           <select name='id2' id='id2' hidden="hidden">
           <?php 
           $getques2 = $db->query("SELECT * FROM questions");
            while($rows2 = $getques2->fetch_assoc()){
                $thisid2 = $rows2['QuestionID'];
                $thisques2 = $rows2['Question'];
                $thisans2 = $rows2['TeacherAnswer'];
                echo "<option value='$thisid2'>$thisid2 : $thisques2 : $thisans2</option>";
            }
        ?>
        </select>
            <div class="drop-down" id="drop-down2">
                <div class="name" id="assign-drop">Question Id : <span id="selected-drop2"></span></div>
                <div id="drop-button">▼</div>
            </div>
            <div class="options-cont" id="options2">
                <ul>
                <?php
                    $getques2 = $db->query("SELECT * FROM questions");  
                    while($rows2 = $getques2->fetch_assoc()){
                        $thisid2 = $rows2['QuestionID'];
                        $thisques2 = $rows2['Question'];
                        $thisans2 = $rows2['TeacherAnswer'];
                        echo "<li class='option2'>$thisid2</li>";
                    }
                ?>  
                </ul>
            </div>
            <div class="after-drop">
                <div class="name">New Answer</div>
                <div class="text-field">
                    <input type="text" required name="newans" placeholder="Enter New Answer">
                    <span></span>
                </div>

            </div>
            <div id="exit-drop" class="close"></div>
            <input type="submit" name="changesubmit" value="Change" class="submit">
        </form>
    </div>

</div>

<h1 class="table-title">Q&A</h1>
        <?php
        if(isset($_POST['changesubmit']) && isset($_POST['id2'])){
            $id2 = $_POST['id2'];
            $na = $_POST['newans']; //New Answer
            if(validName($na)){
                $changesql = "UPDATE `questions` SET `TeacherAnswer` = '$na' WHERE(`QuestionID`= '$id2')";
                if(!mysqli_query($db, $changesql)){
                    echo "<div class='pop-up'>Answer NOT Changed</div>";
                } else {
                    echo "<div class='pop-up'>Answer Changed!</div>";
                }
            }
        }
        $viewqssql = "SELECT * FROM questions ORDER BY QuestionID DESC";
        $res = mysqli_query($db, $viewqssql);
        $resultCheck = mysqli_num_rows($res);
        if($resultCheck>0){
            echo "<div class='all-quest'>";
            while ($row = mysqli_fetch_assoc($res)){
                echo "<div class='qa-cont'>";
                echo "<div class='question'><span class='quest-title'>Question ".$row['QuestionID'].": </span>";
                echo $row['Question'];
                echo " ~ ".$row['User'];
                echo "</div>"; 

                echo "<div class='answer-teacher'><span class='answer-teacher-title'>Teacher's Answer: </span>";
                echo $row['TeacherAnswer']; 
                echo "</div>";  

                echo "<div class='answer-assistant'><span class='answer-assistant-title'>Assistant's Answer: </span>";
                echo $row['Answer'];
                echo " ~ ".$row['Assistant'];
                echo "</div>";     
                echo "</div>";       
            }
        } else {
            echo "<div class='pop-up'>No questions yet</div>";
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
<script src="styles/dropdown2.js"></script>
</body>
</html>