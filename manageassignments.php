<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post an Assignment</title>
</head>
<body>
<?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){?>
    <h1>Post</h1>
    <hr>
    <form method="POST" enctype="multipart/form-data">
        Description: <input type='text' name='desc' id='desc'><br><br> 
        Due date: <input type="text" name="duedate"> Enter in the form yy-mm-dd hh:mm:ss<br><br>
        <input type="submit" name="postsubmit" value="Submit">
    </form>
    <h1>Remove</h1>
    <hr>
    <form method="POST" enctype="multipart/form-data">
        AssignmentID: <input type='number' name='id' id='id'><br><br> 
        <input type="submit" name="removesubmit" value="Submit">
    </form>
    <h1>Assignments Table</h1>
    <hr>
    <?php
        include "configusers.php";
        echo "Assignment ID : Description : DueDate";
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
            $postassignmentsql = "INSERT INTO assignments(Description, DueDate)VALUES('$d', '$dd')";
            if(!mysqli_query($db, $postassignmentsql)){
                echo "<br><h2>Assignment not Added :(</h2>";
            } else {
                echo "<br><h2>Assignment Added!</h2>";
            }
        }
        $viewassignmentssql = "SELECT * FROM assignments";
        $res = mysqli_query($db, $viewassignmentssql);
        $resultCheck = mysqli_num_rows($res);
        if($resultCheck>0){
            while ($row = mysqli_fetch_assoc($res)){
                echo $row['AssignmentID'];
                echo $row['Description'];
                echo $row['DueDate'];
                echo "<br>";            
            }
        } else {
            echo "Empty";
        }
    }else{
        echo "Access denied";
    }
        ?>
</body>
</html>