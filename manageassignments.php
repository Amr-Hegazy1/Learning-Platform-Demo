<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Assignments Manager</title>
</head>
<body>
<?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){
            include "configusers.php";
            $getavas = $db->query("SELECT * FROM assignments"); //Get available assignments
            ?>
    <h1>Post</h1>
    <hr>
    <form method="POST" enctype="multipart/form-data">
        Description: <input type='text' name='desc' id='desc'><br><br> 
        Due date: <input type="text" name="duedate"> Enter in the form yy-mm-dd hh:mm:ss<br><br>
        Maximum Grade: <input type='number' name='maxgrade'><br><br> 
        <input type="submit" name="postsubmit" value="Submit">
    </form>
    <h1>Remove</h1>
    <hr>
    <form method="POST" enctype="multipart/form-data">
        AssignmentID: <select name='id' id='id'>
        <?php 
            while($rows = $getavas->fetch_assoc()){
                $thisid = $rows['AssignmentID'];
                $thisdesc = $rows['Description'];
                $thisdd = $rows['DueDate'];
                echo "<option value='$thisid'>$thisid : $thisdesc : $thisdd</option>";
            }
        ?>   
        <br><br> 
        <input type="submit" name="removesubmit" value="Remove">
    </form>
    <h1>Assignments Table</h1>
    <hr>
    <?php
        if(isset($_POST['removesubmit'])){
            $id = $_POST["id"];
            $removeassistantsql = "DELETE FROM `assignments` WHERE(`AssignmentID`= '$id')";
            if(!mysqli_query($db, $removeassistantsql)){
                echo "<br><h2>Assignment not Removed :(</h2><br>";
            } else {
                echo "<br><h2>Assignment Removed!</h2><br>";}
        }
        if(isset($_POST['postsubmit'])){
            $d = $_POST['desc'];
            $dd = $_POST['duedate'];
            $mg = $_POST['maxgrade'];
            $postassignmentsql = "INSERT INTO assignments(Description, DueDate, MaxGrade)VALUES('$d', '$dd', '$mg')";
            if(!mysqli_query($db, $postassignmentsql)){
                echo "<br><h2>Assignment not Added :(</h2>";
            } else {
                echo "<br><h2>Assignment Added!</h2>";
            }
            $getlastcol = $db->query("SELECT `AssignmentID` FROM `assignments` ORDER BY `AssignmentID` DESC LIMIT 1");
            while($rows = $getlastcol->fetch_assoc()){
                $addid = $rows['AssignmentID'];
            }
            $addcolsql = "ALTER TABLE `progress` ADD `$addid` int(11) NOT NULL";
            mysqli_query($db, $addcolsql);
        }
        $viewassignmentssql = "SELECT * FROM assignments";
        $res = mysqli_query($db, $viewassignmentssql);
        $resultCheck = mysqli_num_rows($res);
        $out = '<table class="table" border="1"><thead><tr>';
        if($resultCheck>0){
            $out .="<th>Assignment ID</th><th>Description</th><th>Due Date</th><th>Maximum Grade</th></tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($res)){
                $out .="<tr><td>".$row['AssignmentID']."</td>";
                $out .= "<td>".$row['Description']."</td>";
                $out .= "<td>".$row['DueDate']."</td>";
                $out .= "<td>".$row['MaxGrade']."</td></tr>";
            }
            $out .="</tbody></table>";
            echo $out;
        } else {
            echo "Empty";
        }
    }else{
        echo "Access denied";
    }
        ?>
</body>
</html>