<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Format</title>
    <link rel="stylesheet" href="styles/styles.css">

</head>
<body>
    <?php
     try{
        $ali = false;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){
            include_once("nav.html");
            $selected = $_SESSION['selected'];?>
        
            <div class="container center">
                <div class="segment single-seg reset-seg">
                        <h1 class="title">Reset</h1>
                        <div class="line"></div>
                        <div class="center" id="reset-desc">Reset the tables you no longer need</div>
                        <form method="POST" class="reset-form"enctype="multipart/form-data">
                            <div class="check-cont">
                                <input type="checkbox" id="check1" name="tables[]" value="users">
                                <label for="check1">Users</label>
                            </div>
                            
                            <div class="check-cont">
                                <input type="checkbox" id="check2" name="tables[]" value="assistants">
                                <label for="check2">Assistants</label>
                            </div>

                            <div class="check-cont">
                                <input type="checkbox" id="check3" name="tables[]" value="assignments">
                                <label for="check3">Assignments</label>
                            </div>


                            <div class="check-cont">
                                <input type="checkbox" id="check4" name="tables[]" value="videos">
                                <label for="check4">Videos</label>
                            </div>

                            <div class="check-cont">
                                <input type="checkbox" id="check5" name="tables[]" value="posts">
                                <label for="check5">Posts</label>
                            </div>

                            <div class="check-cont">
                                <input type="checkbox" id="check6" name="tables[]" value="questions">
                                <label for="check6">Questions</label>
                            </div>
                            <input type="submit" name="format" value="Format" class="submit">
                        </form>
                </div>
            </div>

        <?php 
            include "configeach.php";
            if(isset($_POST['format'])&&isset($_POST["tables"])){

                $tables = $_POST["tables"];
                $new = array_push($tables, "progress", "work");

                if(in_array("videos", $tables)){
                    clearVideos($db);
                }

                if(in_array("posts", $tables)){
                    clearAttachments($db);
                }

                clearWorkAndReturns($db);

                $len = count($tables);
                for($i = 0; $i < $len; $i++){
                    $ctable = $tables[$i];
                    $sql = $db->query("DELETE FROM `$ctable`");
                    echo "<div class='pop-up'>".$ctable." formatted </div>";

                }

                clearProgCols($db, $selected);
            }
        }else{
            echo "Access denied<br>";
            echo '<a href="index.php">Go Home</a><br>';;
        }
        
        
    }catch( Error $ex){
        echo $ex;
    }catch(Exception $ex){
        echo $ex;
    }
        
        ?>

<?php 

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

function clearProgCols($db, $selected){
    $array = getProgColNames($db, $selected);
    $len = count($array);
    for($i = 0; $i < $len; $i++){
        $sql = $db->query("ALTER TABLE `progress` DROP COLUMN `$array[$i]`");
    }
}

function getProgColNames($db, $selected){
    $sql = $db->query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='$selected' AND `TABLE_NAME`='progress'");
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