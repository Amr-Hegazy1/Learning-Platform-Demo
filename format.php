<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Format</title>
    <link rel="stylesheet" href="http://localhost/TCD/styles.css">

</head>
<body>
    <?php
        $ali = false;
        if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){
            include_once("nav.html");?>
        
            <div class="container" id="cont-add-admin">
                <div class="segment">
                        <h1 class="title">Format</h1>
                        <h4>Format at end of session the tables you no longer need</h4>
                        <div class="line"></div>
                        <form method="POST" enctype="multipart/form-data">

                            <input type="checkbox" name="tables[]" value="users"> Users<br>
                            <input type="checkbox" name="tables[]" value="assistants"> Assistants<br>
                            <input type="checkbox" name="tables[]" value="assignments"> Assignments<br>
                            <input type="checkbox" name="tables[]" value="videos"> Videos<br>
                            <input type="checkbox" name="tables[]" value="posts"> Posts<br>
                            <input type="checkbox" name="tables[]" value="questions"> Questions<br>

                            <input type="submit" name="format" value="Format" class="submit">
                        </form>
                </div>
            </div>

        <?php 
            include "configusers.php";
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

                clearProgCols($db);
            }

        }else{
            echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';;
        }
        
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

        function clearProgCols($db){
            $array = getProgColNames($db);
            $len = count($array);
            for($i = 0; $i < $len; $i++){
                $sql = $db->query("ALTER TABLE `progress` DROP COLUMN `$array[$i]`");
            }
        }

        function getProgColNames($db){
            $sql = $db->query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='users' AND `TABLE_NAME`='progress'");
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