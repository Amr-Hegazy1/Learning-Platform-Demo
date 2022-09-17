<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<?php 
session_start();
include "configcourses.php";
include_once("nav-manager.html");
?>
<div class="container-manage-user">
    <div class="container" id="cont-add-admin">
        <div class="segment single-seg add-user-seg">

            <h1 class="title">Add Course</h1>
            <div class="line"></div>

            <form method="POST" enctype="multipart/form-data">

                <div class="name">Title</div>
                <div class="text-field">
                    <input type="text" required name="title" placeholder="Enter Title">
                    <span></span>
                </div>

                <div class="name">Description</div>
                <div class="text-field">
                    <input type="text" required name="desc1" placeholder="Enter course description">
                    <span></span>
                </div>

                <!--
                <div class="name">Second Description</div>
                <div class="text-field">
                    <input type="text" name="desc2" placeholder="Enter second part of description">
                    <span></span>
                </div>

                <div class="name">Third Description</div>
                <div class="text-field">
                    <input type="text" name="desc3" placeholder="Enter third part of description">
                    <span></span>
                </div>
                -->


                <select name='inst' id='id' hidden="hidden">

                                <?php
                                    $results1 = $dbc->query("SELECT * FROM `instructors`"); 
                                    while($eachinst = $results1->fetch_assoc()){
                                        $thisinst = $eachinst['Instructor'];
                                        echo "<option value='$thisinst'>$thisinst</option>";
                                    }
                                ?>   
                            </select>

                            <div class="drop-down" id="drop-down">
                                <div class="name" id="assign-drop">Instructor : <span id="selected-drop"></span></div>
                                <div id="drop-button">▼</div>
                            </div>

                            <div class="options-cont" id="options">
                                <ul>
                                    <?php
                                    $results1 = $dbc->query("SELECT * FROM `instructors`"); 
                                    while($eachinst = $results1->fetch_assoc()){
                                        $thisinst = $eachinst['Instructor'];
                                        echo "<li class='option'>$thisid</li>";
                                    }
                                    ?>   
                                </ul>
                            </div>
                            <div id="exit-drop" class="close"></div>
                
                
                <select name='d' id='id2' hidden="hidden">

                                <?php
                                    $a = getAvailableDatabases($dbc);
                                    for($i=0; $i<count($a);$i++){
                                        echo "<option value='$a[$i]'>$a[$i]</option>";
                                    }
                                ?>   
                            </select>

                            <div class="drop-down" id="drop-down2">
                                <div class="name" id="assign-drop">Database : <span id="selected-drop2"></span></div>
                                <div id="drop-button">▼</div>
                            </div>

                            <div class="options-cont database-options" id="options2">
                                <ul>
                                    <?php
                                    $a = getAvailableDatabases($dbc);
                                    for($i=0; $i<count($a);$i++){
                                        echo "<li class='option2'>$a[$i]</li>";
                                    }
                                    ?>   
                                </ul>
                            </div>

                
                <div class="name">Price</div>
                <div class="text-field">
                    <input type="number" required name="price" placeholder="Enter Course Price">
                    <span></span>
                </div>


                <div class="name">Attach Image</div>
                <input type="file" id="file-button" required name="cimage" class="file-input" hidden="hidden">
                <label for="file-button" class="choose-file">
                    Choose Image :<span id="file-text">No Image Chosen</span>
                </label>
                <span></span>


                <input type="submit" name="postsubmit" value="Add" class="submit">
            </form>
        </div>
    </div>


<?php 
if($_SESSION['manager']){
    include "configcourses.php";
    if(isset($_POST['addsubmit'])){
        $title = $_POST['title'];
        $desc1 = $_POST['desc1'];
        $desc2 = $_POST['desc2'];
        $desc3 = $_POST['desc3'];
        $inst = $_POST['inst'];
        $d = $_POST['d'];
        $price =$_POST['price'];
        $filename = $_FILES["cimage"]["name"];
        $tempname = $_FILES["cimage"]["tmp_name"];
        $folder = "images/" . $filename;
        move_uploaded_file($tempname, $folder);
        addCourse($dbc, $title, $d, $inst, $desc1, $desc2, $desc3, $price, $folder);
        header("Refresh:1");
    }
} else { echo "Access denied<br>"; echo '<a href="signin.php">Go Home</a><br>';}
?>











<?php
    if($_SESSION['manager']){
        $sql = $dbc->query("SELECT `Manager` FROM `managers` LIMIT 1");
        if($adminrow = $sql->fetch_assoc()){
            $admin = $adminrow['Manager'];
        }
        ?>
        <div class="container center">
            <div class="segment add-user-seg-bottom">

                <h1 class="title">Remove Course</h1>
                <div class="line"></div>      

                <form method="POST" enctype="multipart/form-data">

                    <select name='course' id='id3' hidden="hidden">

                        <?php
                            $results = $dbc->query("SELECT * FROM `courses`"); 
                            while($each = $results->fetch_assoc()){
                                $thiscourse = $each['Title'];
                                $thisd = $each['D'];
                                $thisinst = $each['Instructor'];
                                echo "<option value='$thisd'>$thiscourse By $thisinst</option>";
                            }
                        ?>

                    </select>
                    <div class="drop-down" id="drop-down3">
                        <div class="name" id="assign-drop">Instructor ID : <span id="selected-drop3"></span></div>
                        <div id="drop-button">▼</div>
                    </div>
                    <div class="options-cont" id="options3">
                        <ul>
                        <?php
                            $results = $dbc->query("SELECT * FROM `courses`"); 
                            while($each = $results->fetch_assoc()){
                                $thiscourse = $each['Title'];
                                $thisd = $each['D'];
                                $thisinst = $each['Instructor'];
                                echo "<li class='option3'>$thisidr</li>";
                            }
                        ?>  
                        </ul>
                    </div>

                    <input type="submit" name="removerec" value="Remove" class="submit">

                </form>
            </div>
        </div>    
    </div>
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

function addCourse($db, $title, $d, $inst, $desc1, $desc2, $desc3, $price, $img){
    $db->query("INSERT INTO `courses`(`Title`, `D`, `Instructor`, `Description1`, `Description2`,`Description3`, `Price`, `Image`) VALUES ('$title', '$d', '$inst', '$desc1', '$desc2','$desc3', $price, '$img')");
    echo $title." added";
}

function getAvailableDatabases($db){
    $sql = $db->query("SELECT * FROM `courses`");
    $all = ["d1","d2","d3","d4","d5"];
    $array = array();
    $return = array();
    while($r = $sql->fetch_assoc()){
        if(!in_array($r['D'], $array)){
            array_push($array, $r['D']);
        }
    }
    for($i = 0; $i < count($all); $i++ ){
        if(!in_array($all[$i], $array)){
            array_push($return, $all[$i]);
        }
    }
    return $return;
}

?>
<script src="dropdown3.js"></script>
<script src="chooseFile.js"></script>
</body>
</html>
