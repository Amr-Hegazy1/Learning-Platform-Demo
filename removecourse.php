<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Course</title>
    <link rel="stylesheet" href="http://localhost/Outershell/styles.css">
    <link rel="stylesheet" href="nav-style.css">

</head>
<body>
<?php 
    session_start();
    if($_SESSION['manager']){
        include "configcourses.php";
        $sql = $dbc->query("SELECT `Manager` FROM `managers` LIMIT 1");
        if($adminrow = $sql->fetch_assoc()){
            $admin = $adminrow['Manager'];
        }
        ?>
        <form method="POST" enctype="multipart/form-data">
            Choose a Course: <select name='course' id='course'>
                <?php
                    $results = $dbc->query("SELECT * FROM `courses`"); 
                    while($each = $results->fetch_assoc()){
                        $thiscourse = $each['Title'];
                        $thisd = $each['D'];
                        $thisinst = $each['Instructor'];
                        echo "<option value='$thisd'>$thiscourse By $thisinst</option>";
                    }
                ?>   
            </select><br><br>
            <input type="submit" name="removec" value="Remove">
        </form>
<?php 
    if(isset($_POST['removec'])){
        $_SESSION['selected'] = $_POST['course'];
        $d = $_SESSION['selected'];
        include "configeach.php";
        $removeassistants = $db->query("DELETE FROM `assistants`");
        $removeusers = $db->query("DELETE FROM `users`");
        $removeques = $db->query("DELETE FROM `questions`");
        clearVideos($db);
        $removevideos = $db->query("DELETE FROM `videos`");
        clearAttachments($db);
        $removeposts = $db->query("DELETE FROM `posts`");
        clearWorkAndReturns($db);
        $removework = $db->query("DELETE FROM `work`");
        $removeprogress = $db->query("DELETE FROM `progress`");
        clearProgCols($db, $d);
        $removeassignments = $db->query("DELETE FROM `assignments`");
        removeOtherAdmins($db, $admin);
        $removecourse = $dbc->query("DELETE FROM `courses` WHERE `D` = '$d'");

    }
} else { echo "Access denied<br>"; echo '<a href="signin.php">Go Home</a><br>';}

function clearVideos($db){
    $sql = $db->query("SELECT `VideoLocation` FROM `videos`");
    while($row = $sql->fetch_assoc()){
        $loc = $row['VideoLocation'];
        unlink($loc);
    }
}

function clearAttachments($db){
    $sql = $db->query("SELECT `attachments` FROM `posts`");
    while($row = $sql->fetch_assoc()){
        $loc = $row['attachments'];
        if($loc != "attachments/"){
            if(!unlink($loc)){
                echo "<div class='pop-up'>Error</div>";
            }
        }
    }
}

function clearWorkAndReturns($db){
    $sql = $db->query("SELECT * FROM `work`");
    while($row = $sql->fetch_assoc()){
        $loc = $row['WorkFile'];
        $corrected = $row['Corrected'];
        if($corrected == 1){
            $returnfile = "returns".substr($loc, 4);
            if(!unlink($returnfile)){
                echo "<div class='pop-up'>Error</div>";
            }
        }
        unlink($loc);
    }
}

function removeOtherAdmins($db, $admin){
    $sql = $db->query("SELECT * FROM `admins`");
    while($row = $sql->fetch_assoc()){
        $a = $row['Username'];
        if($a != $admin){
            $removeadmin = $db->query("DELETE FROM `admins` WHERE `Username` = '$a'");
        }
    }
}

function clearProgCols($db, $selected){
    $array = getProgColNames($db, $selected);
    $len = count($array);
    for($i = 0; $i < $len; $i++){
        $sql = $db->query("ALTER TABLE `progress` DROP COLUMN `$array[$i]`");
    }
}

function getProgColNames($db, $d){
    $sql = $db->query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='$d' AND `TABLE_NAME`='progress'");
    $array = array();
    while($row = $sql->fetch_assoc()){
        $name = $row['COLUMN_NAME'];
        if($name!="UserID"){
            array_push($array, $name);
        }
    }
    return($array);
}

?>
</body>
</html>