<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Work</title>
</head>
<body>
    <?php 
        include_once("nav-assistant.html");
        include "configusers.php";
        echo "<h1>View Students' Work</h1>";
        $li = false;
        session_start();
        $a = $_SESSION['assistant'];
        if(isset($_SESSION['assistantloggedin'])){
            $li = $_SESSION['assistantloggedin'];}
        if($li){ 
            include "configusers.php";
            $getavas = $db->query("SELECT `AssignmentID` FROM assignments"); //Get available assignments

            ?>
        <form method="POST" enctype="multipart/form-data">
            Assignment ID: <select name='id' id='id'>
        <?php 
            while($rows = $getavas->fetch_assoc()){
                $thisid = $rows['AssignmentID'];
                echo "<option value='$thisid'> Assignment $thisid</option>";
            }
        ?> 
            <input type="submit" name='submit' value="Submit" id='submit'>
        </form>
    <?php
        if(isset($_POST['submit'])){
            $assignmentid = $_POST['id'];
            $viewworksql = "SELECT * FROM work WHERE `AssignmentID`= '$assignmentid' AND `Corrected`=0 ORDER BY `WorkID` ASC";
            $res = mysqli_query($db, $viewworksql);
            if(mysqli_num_rows($res)>0){
                while ($work = mysqli_fetch_assoc($res)){
                    $wid = $work['WorkID'];
                    $_SESSION['wid'] = $wid;
                    echo "$wid  :  ";
                    $user = $work['UserID'];
                    echo "$user  :  ";
                    $late = lateCheck($work['Late']);
                    echo "$late  :  ";
                    $grade = $work['Grade'];
                    echo '<a href="./correctingpage.php?workFile='.$work['WorkFile'].'"/> Correct </a><br>';
                }            
            } else {
                echo "<div class='pop-up'>No assignments submitted</div>";
            }
        }
        } else {
            echo "Access Denied";
        }
        function lateCheck($x){
            if($x == 0){
                return "On Time";
            }else {
                return "Late";
            }
        }
    ?>
</body>
</html>