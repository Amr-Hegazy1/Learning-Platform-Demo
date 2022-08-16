<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Submission</title>
</head>
<body>
    <?php
        $li = false;
        session_start();
        if(isset($_SESSION['loggedin'])){
            $li = $_SESSION['loggedin'];}
        if($li){
            include "configusers.php";
            $getavas = $db->query("SELECT * FROM assignments"); //Get available assignments?>
            <form method="POST" enctype="multipart/form-data">
                Assignment ID: <select name='id' id='id'>
                <?php 
                    while($rows = $getavas->fetch_assoc()){
                        $thisid = $rows['AssignmentID'];
                        $thisdesc = $rows['Description'];
                        $thisdd = $rows['DueDate'];
                        echo "<option value='$thisid'>$thisid : $thisdesc : $thisdd</option>";
                    }
                ?>   
                <input type="file" name="work"><br><br>
                <input type="submit" name="submit" value="Submit">
            </form>
    <?php
        $username = $_SESSION['username'];
        if(isset($_POST['submit'])){
            $inputid = $_POST['id'];
            if(!alreadySubmitted($username, $inputid, $db)){
                $viewduedatesql = "SELECT DueDate FROM assignments WHERE `AssignmentID`= $inputid";
                $res = mysqli_query($db, $viewduedatesql);
                $resultCheck = mysqli_num_rows($res);
                if($resultCheck=1){
                    while ($row = mysqli_fetch_assoc($res)){
                        $duedate = $row['DueDate'];
                        echo "<br>";            
                    }
                } else {
                    echo "Error";}

                $filename = $_FILES["work"]["name"];
                $tempname = $_FILES["work"]["tmp_name"];
                $folder = "work/" . $filename;
                move_uploaded_file($tempname, $folder);
                date_default_timezone_set('Africa/Cairo');
                $submitdate = date("Y-m-d H:i:s");
                if($submitdate >= $duedate){
                    $latebit = 1;
                    echo "You submitted late :(";
                } else {
                    $latebit = 0;
                    echo "You submitted on time (:";
                }
                $insertworksql = "INSERT INTO `work`(`UserID`, `AssignmentID`, `WorkFile`, `Late`)VALUES('$username', '$inputid', '$folder', '$latebit')";
                if(!mysqli_query($db, $insertworksql)){
                    echo "<br><h2>Error :(</h2>";
                } else {
                    echo "<br><h2>Submitted</h2>";
                }
            }else{echo "You have already submitted this assignment";}
        }
        $viewassignmentssql = "SELECT * FROM assignments";
        $res = mysqli_query($db, $viewassignmentssql);
        $resultCheck = mysqli_num_rows($res);
        if($resultCheck>0){
            echo "<h4>AssignmentID : Description : DueDate </h4>";
            while ($row = mysqli_fetch_assoc($res)){
                echo $row['AssignmentID']." : ";
                echo $row['Description']." : ";
                echo $row['DueDate'];
                echo "<br>";            
            }
        } else {
            echo "No Assignments yet";
        } 
    }else{
        echo "Access Denied";
    }
    function alreadySubmitted($u, $aid, $db){
        $checksql = "SELECT * FROM `work` WHERE `UserID` = '$u' AND `AssignmentID` = '$aid'";
        $r = mysqli_query($db, $checksql);
        $n = mysqli_num_rows($r);
        if($n == 1){return true;}else{return false;}; 
    }
    ?>
</body>
</html>