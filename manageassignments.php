<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Assignments Manager</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<?php include_once("nav.html") ?>
<?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){
            include "configusers.php";
            ?>

            <div class="container">

                <div class="segment">

                        <h1 class="title">Post</h1>
                        <div class="line"></div>

                    <form method="POST" enctype="multipart/form-data">
        
                        <div class="name">Description</div>
                        <div class="text-field">
                            <input type="text" required name="desc" id="desc" placeholder="Enter Description">
                            <span></span>
                        </div>
        
                        <div class="name">Due Date</div>
                        <div class="text-field">
                            <input type="text" required name="duedate" placeholder="YY-MM-DD HH-MM-SS">
                            <span></span>
                        </div>
        
                        <div class="name">Max Grade</div>
                        <div class="text-field">
                            <input type="text" required name="maxgrade" placeholder="Enter Maximum Grade">
                            <span></span>
                        </div>

                        <input type="submit" name="postsubmit" value="Post" class="submit">
                    </form>
                </div>
            
            
                <div class="segment">

                    <h1 class="title">Remove</h1>
                    <div class="line"></div>

                    <form method="POST" enctype="multipart/form-data">

                        <select name='id' id='id' hidden="hidden">

                            <?php
                                $getavas = $db->query("SELECT * FROM `assignments`");

                                while($rows = $getavas->fetch_assoc()){
                                    $thisid = $rows['AssignmentID'];
                                    $thisdesc = $rows['Description'];
                                    $thisdd = $rows['DueDate'];
                                    echo "<option value='$thisid'>$thisid : $thisdesc : $thisdd</option>";
                                }
                            ?>   
                        </select>

                        <div class="drop-down" id="drop-down">
                            <div class="name" id="assign-drop">Assignment ID : <span id="selected-drop"></span></div>
                            <div id="drop-button">▼</div>
                        </div>

                        <div class="options-cont" id="options">
                            <ul>
                                <?php
                                    $getavax = $db->query("SELECT * FROM `assignments`");
                                    while($rows = $getavax->fetch_assoc()){
                                        $thisid = $rows['AssignmentID'];
                                        $thisdesc = $rows['Description'];
                                        $thisdd = $rows['DueDate'];
                                        echo "<li class='option'>$thisid</li>";
                                    }
                                ?>   
                            </ul>
                        </div>
                        <div id="exit-drop" class="close"></div>

                        <input type="submit" name="removesubmit" value="Remove" class="submit">
                        
                    </form>
                </div>
            </div>        

            <?php
        if(isset($_POST['removesubmit'])){
            $id = $_POST['id'];
            $removeassistantsql = "DELETE FROM `assignments` WHERE(`AssignmentID`= '$id')";
            if(!mysqli_query($db, $removeassistantsql)){
                echo "<div class='pop-up'>Assignment not removed</div>";
            } else {
                echo "<div class='pop-up'>Assignment removed</div>";
                header("Refresh:1");
            }
        }
        if(isset($_POST['postsubmit'])){
            $d = $_POST['desc'];
            $dd = $_POST['duedate'];
            $mg = $_POST['maxgrade'];
            if(strlen($d)>0){
                if(validateDate($dd)){
                    if(maxGradeVal($mg)){
                        $postassignmentsql = "INSERT INTO assignments(Description, DueDate, MaxGrade)VALUES('$d', '$dd', '$mg')";
                        if(!mysqli_query($db, $postassignmentsql)){
                            echo "<div class='pop-up'>Assignment not Added</div>";
                        } else {
                            echo "<div class='pop-up'>Assignment Added!</div>";
                            $getlastcol = $db->query("SELECT `AssignmentID` FROM `assignments` ORDER BY `AssignmentID` DESC LIMIT 1");
                            while($rows = $getlastcol->fetch_assoc()){
                                $addid = $rows['AssignmentID'];
                            }
                            $addcolsql = "ALTER TABLE `progress` ADD `$addid` int(11) NOT NULL";
                            mysqli_query($db, $addcolsql);
                        }
                    } else {echo "<div class='pop-up'>Max Grade must be a positive number</div>";}
                } else {echo "<div class='pop-up'>Invalid date format</div>";} 
            }else{echo "<div class='pop-up'>Description cannot be empty</div>";}
        }?>


    <h1 class="table-title">Assignments Table</h1>
    
    <?php
        $viewassignmentssql = "SELECT * FROM assignments";
        $res = mysqli_query($db, $viewassignmentssql);
        $resultCheck = mysqli_num_rows($res);
        $out = '<div class="table-cont">
                <table class="table"><thead><tr>';        
        if($resultCheck>0){
            $out .="<th>Assignment ID</th><th>Description</th><th>Due Date</th><th>Maximum Grade</th></tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($res)){
                $out .="<tr><td>".$row['AssignmentID']."</td>";
                $out .= "<td>".$row['Description']."</td>";
                $out .= "<td>".$row['DueDate']."</td>";
                $out .= "<td>".$row['MaxGrade']."</td></tr>";
            }
            $out .="</tbody></table></div>";
            echo $out;
        } else {
            echo "<div class='pop-up'>Empty</div>";
        }
    }else{
        echo "Access denied<br>";
        echo '<a href="signin.php">Go Home</a><br>';;
    }

    function validateDate($date){
        $format = 'Y-m-d H:i:s';
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    function maxGradeVal($n){
        if($n>0){
            return true;
        }
        return false;
    }
        ?>
</body>
</html>