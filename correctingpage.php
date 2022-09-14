<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correcting</title>
    <link rel="stylesheet" href="styles/styles.css">

</head>
<body>
<?php
    $li = false;
    session_start();
    if(isset($_SESSION['assistantloggedin'])){
        $li = $_SESSION['assistantloggedin'];}
    if($li){
        include "configeach.php";
        $wid = $_SESSION['wid'];
        getMaxGrade($db, $wid);
        $a = $_SESSION['assistant'];
        $opensql = "SELECT * FROM work WHERE `WorkID` = '$wid'";
        $res = mysqli_query($db, $opensql);
        if(mysqli_num_rows($res)>0){
            while ($work = mysqli_fetch_assoc($res)){
            ?>
                <embed src="./PdfEditor/index.php?workFile=<?php echo $_GET["workFile"]?>" style="height: 85%;width: 90%;">  <br><br>              
                <form method="POST" enctype="multipart/form-data">
                    Comments: <input type="text" required name="comments">
                    Grade: <input type="number" required name="grade">
                    <input type="submit" name='returnsubmit' value="Return">
                </form>
            <?php
            }
            if(isset($_POST['returnsubmit'])){
                $grade = $_POST['grade'];
                $comments = $_POST['comments'];
                $updatesql = "UPDATE `work` SET `Grade`='$grade', `Comments`='$comments', `AssistantID`='$a', `Corrected`=1 WHERE `WorkID` = '$wid'";
                if(!mysqli_query($db, $updatesql)){
                    echo "<div class='pop-up'>Not Returned</div>";
                } else {
                    echo "<div class='pop-up'>Returned</div>";
                    header("Location:./viewwork.php");
                    exit();
                }
            }
        } else {
            echo "<div class='pop-up'>File not found</div>";
        }
    }else{
            echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';;
        }

        function getMaxGrade($db, $id){
            $sql = $db->query("SELECT `AssignmentID` FROM `work` WHERE `WorkID`='$id' LIMIT 1");
            if($row = $sql->fetch_assoc()){
                $aid = $row['AssignmentID'];
            }
            $sql2 = $db->query("SELECT `MaxGrade` FROM `assignments` WHERE `AssignmentID`='$aid'");
            if($x = $sql2->fetch_assoc()){
                $y = $x['MaxGrade'];
            }
            return "/$y";
        }
    ?>
</body>
</html>