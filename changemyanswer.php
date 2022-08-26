<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Change My Answer</title>
</head>
<body>
    <?php 
        include_once("nav-assistant.html");
        include "configusers.php";
        $li = false;
        session_start();
        $a = $_SESSION['assistant'];
        if(isset($_SESSION['assistantloggedin'])){
            $li = $_SESSION['assistantloggedin'];}
        if($li){
            include "configusers.php";
            $getques = $db->query("SELECT * FROM questions"); //Get available questions
            $getques2 = $db->query("SELECT * FROM questions"); //Get available questions?>
                
                
                <div class="container">  
            <div class="segment">
            <h1 class="title">Remove Answer</h1>
            <div class="line"></div>
            <form method="POST" enctype="multipart/form-data">
           <select name='id' id='id' hidden="hidden">
           <?php 
            while($rows = $getques->fetch_assoc()){
                $thisid = $rows['QuestionID'];
                $thisques = $rows['Question'];
                $thisans = $rows['Answer'];
                echo "<option value='$thisid'>$thisid : $thisques : $thisans</option>";
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
                            $thisans = $rows['Answer'];
                            echo "<li class='option'>$thisid</li>";
                        }
                    ?>  
                    </ul>
                </div>
                <div id="exit-drop" class="close"></div>
                <input type="submit" name="removesubmit" value="Remove" class="submit">
            </form>
        </div>

        <div class="segment">
            <h1 class="title" id="change-ans">Change Answers</h1>
            <div class="line"></div>
            <form method="POST" enctype="multipart/form-data">
           <select name='id2' id='id2' hidden="hidden">
           <?php 
            while($rows2 = $getques2->fetch_assoc()){
                $thisid2 = $rows2['QuestionID'];
                $thisques2 = $rows2['Question'];
                $thisans2 = $rows2['Answer'];
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
                            $thisans2 = $rows2['Answer'];
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


            <?php
            if(isset($_POST['removesubmit'])){
                $id = $_POST["id"];
                $removeqsql = "UPDATE `questions` SET `Answer` = 'Not Answered yet', `Answered` = 0 WHERE(`QuestionID`= '$id')";
                if(!mysqli_query($db, $removeqsql)){
                    echo "<div class='pop-up'>Error :(</div>";
                } else {
                    echo "<div class='pop-up'>Answer Removed</div>";}
            }
            ?>
            <?php
            if(isset($_POST['changesubmit'])){
                $id2 = $_POST['id2'];
                $na = $_POST['newans']; //New Answer
                $changesql = "UPDATE `questions` SET `Answer` = '$na' WHERE(`QuestionID`= '$id2')";
                if(!mysqli_query($db, $changesql)){
                    echo "<div class='pop-up'>Error :(</div>";
                } else {
                    echo  "<div class='pop-up'>Answer Changed</div>";}
            }
            $viewqssql = "SELECT * FROM questions ORDER BY QuestionID DESC";
            $res = mysqli_query($db, $viewqssql);
            $resultCheck = mysqli_num_rows($res);
            if($resultCheck>0){
                echo "<h1 class='table-title'>Q&A</h1>
                <hr>";
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
                echo "</div>";
            } else {
                echo "<div class='pop-up'>Empty</div>";
            }

        }else{
            echo "Access Denied";
        }
        ?>
        <script src="dropdown2.js"></script>
</body>
</html>