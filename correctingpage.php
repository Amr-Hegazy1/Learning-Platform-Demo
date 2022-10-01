<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correcting</title>
    <link rel="stylesheet" href="./styles/styles.css">

</head>
<body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function save(){
            
            if (document.getElementsByName("comments")[0].value != "" && document.getElementsByName("grade")[0].value != ""){
                document.getElementById("pdf-viewer").contentWindow.postMessage("save","*");
                formData = new FormData();
                formData.append("comments",document.getElementsByName("comments")[0].value);
                formData.append("grade",document.getElementsByName("grade")[0].value);
                
                $.ajax({
                url: "correctingpage.php",
                type: "POST",
                data:formData,
                processData: false,
                contentType: false
                });
                
                
            }
        }
    </script>
<?php
 try{
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
    $li = false;
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
                <iframe src="./PdfEditor/index.php?workFile=<?php echo $_GET["workFile"]?>" style="height: 85%;width: 100%;" id="pdf-viewer"></iframe>  <br><br>              
                
                Comments: <input type="text" required name="comments">
                Grade: <input type="number" required name="grade">
                <button  name='returnsubmit' onclick="save()">Save</button>
                
            <?php
            }
            if(isset($_POST['grade']) && isset($_POST['comments'])){
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
            echo '<a href="index.php">Go Home</a><br>';
        }
}catch( Error $ex){
    echo $ex;
}catch(Exception $ex){
    echo $ex;
}
    
    ?>
    
</body>

</html>