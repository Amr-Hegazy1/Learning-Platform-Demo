<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change My Answer</title>
</head>
<body>
    <?php 
        include "configusers.php";
        echo "<h1>Change My Answer</h1>";
        $li = false;
        session_start();
        $a = $_SESSION['assistant'];
        if(isset($_SESSION['assistantloggedin'])){
            $li = $_SESSION['assistantloggedin'];}
        if($li){ 
            include "configusers.php";
            $getques = $db->query("SELECT * FROM questions"); //Get available questions
            $getques2 = $db->query("SELECT * FROM questions"); //Get available questions?>
                <h1>Remove Answer</h1>
                <hr>
            <form method="POST" enctype="multipart/form-data">
                QuestionID: <select name='id' id='id'>
            <?php 
                while($rows = $getques->fetch_assoc()){
                    $thisid = $rows['QuestionID'];
                    $thisques = $rows['Question'];
                    $thisans = $rows['Answer'];
                    echo "<option value='$thisid'>$thisid : $thisques : $thisans</option>";
                }
            ?>  
                <input type="submit" name="removesubmit" value="Submit">
                <hr>
            </form>
            <?php
            if(isset($_POST['removesubmit'])){
                $id = $_POST["id"];
                $removeqsql = "UPDATE `questions` SET `Answer` = 'Not Answered yet', `Answered` = 0 WHERE(`QuestionID`= '$id')";
                if(!mysqli_query($db, $removeqsql)){
                    echo "<br><h2>Answer not Removed :(</h2><br>";
                } else {
                    echo "<br><h2>Answer Removed!</h2><br>";}
            }
            ?>
            <h1>Change My Answers</h1>
            <hr>
            <form method="POST" enctype="multipart/form-data">
                QuestionID: <select name='id2' id='id2'>
            <?php 
                while($rows2 = $getques2->fetch_assoc()){
                    $thisid2 = $rows2['QuestionID'];
                    $thisques2 = $rows2['Question'];
                    $thisans2 = $rows2['Answer'];
                    echo "<option value='$thisid2'>$thisid2 : $thisques2 : $thisans2</option>";
                }
            ?>      <br><input type="text" name="newans">
                <input type="submit" name="changesubmit" value="Change">
                <hr>
            </form>
            <?php
            if(isset($_POST['changesubmit'])){
                $id2 = $_POST['id2'];
                $na = $_POST['newans']; //New Answer
                $changesql = "UPDATE `questions` SET `Answer` = '$na' WHERE(`QuestionID`= '$id2')";
                if(!mysqli_query($db, $changesql)){
                    echo "<br><h2>Answer NOT Changed :(</h2><br>";
                } else {
                    echo "<br><h2>Answer Changed!</h2><br>";}
            }
            $viewqssql = "SELECT * FROM questions ORDER BY QuestionID DESC";
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
            echo "Access Denied";
        }
        ?>
</body>
</html>