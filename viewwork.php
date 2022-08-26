<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Work</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <?php 
        include_once("nav-assistant.html");
        include "configusers.php";
        echo "<h1>View Students' Work</h1><hr>";
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
        ?> </select>
            <input type="submit" name='submit' value="Select" id='submit'>
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
                    echo '<a href="./correctingpage.php?workFile='.$work['WorkFile'].'"/> Correct </a><br>';                }            
            } else {
                echo "No Assignments Submitted yet";
            }
        }
        } else {
                        echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';;
            echo '<br><a href="signin.php">Log in</a>';
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