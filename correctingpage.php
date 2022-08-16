<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correcting</title>
</head>
<body>
<?php
    $li = false;
    session_start();
    if(isset($_SESSION['assistantloggedin'])){
        $li = $_SESSION['assistantloggedin'];}
    if($li){
        include "configusers.php";
        $wid = $_SESSION['wid'];
        $a = $_SESSION['assistant'];
        $opensql = "SELECT * FROM work WHERE `WorkID` = '$wid'";
        $res = mysqli_query($db, $opensql);
        if(mysqli_num_rows($res)>0){
            while ($work = mysqli_fetch_assoc($res)){
            ?>
                <embed src="https://localhost/TCD/<?php echo $work['WorkFile'];?>" height = 400 width= 600>
                <form method="POST" enctype="multipart/form-data">
                    Comments: <input type="text" name="comments">
                    Grade: <input type="number" name="grade">
                    <input type="submit" name='returnsubmit' value="Return">
                </form>
            <?php
            }
            if(isset($_POST['returnsubmit'])){
                $grade = $_POST['grade'];
                $comments = $_POST['comments'];
                $updatesql = "UPDATE `work` SET `Grade`='$grade', `Comments`='$comments', `AssistantID`='$a', `Corrected`=1 WHERE `WorkID` = '$wid'";
                if(!mysqli_query($db, $updatesql)){
                    echo "<br><h2> NotReturned :(</h2>";
                } else {
                    echo "<br><h2>Returned</h2>";
                }
            }
        } else {
            echo "File not found";
        }
    }else{
            echo "Access Denied";
        }
    ?>
</body>
</html>