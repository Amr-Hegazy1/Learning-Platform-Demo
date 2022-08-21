<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Manager</title>
</head>
<body>
    <?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){?>
            <h3>Add Video to database</h3>
            <form method="POST" enctype="multipart/form-data">
                Video ID: <input type="number" name="id"><br><br>
                Video Name: <input type="text" name="name"><br><br>
                Attach Video from Here: <input type='file' name='file' id='file'><br><br> 
                Accessibility: <select name="accessbit" id="access">
                    <option value="1">Available</option>
                    <option value="0">Unavailable</option>
                </select><br><br>
                <input type="submit" name="submit" value="Add">
            </form>
    <?php
        include "configusers.php";
        $getvr = $db->query("SELECT * FROM `videos`");//Get video to be removed
        if(isset($_POST['submit'])){
            $testid = $_POST["id"];
            if(notExists($testid, $db, "VideoID", "videos")){
                $testname = $_POST["name"];
                if(notExists($testname, $db, "VideoName", "videos")){
                    $testaccessbit = $_POST["accessbit"];
                    $filename = $_FILES["file"]["name"];
                    $tempname = $_FILES["file"]["tmp_name"];
                    $folder = "videos/" . $filename;
                    if(notExists($folder, $db, "VideoLocation", "videos")){
                        move_uploaded_file($tempname, $folder);
                        $sql = "INSERT INTO `videos`(`VideoID`,`VideoName`,`VideoLocation`,`Accessebility`)VALUES('$testid', '$testname', '$folder', '$testaccessbit')";
                        if(!mysqli_query($db, $sql)){
                            echo "<br><h2>Video not Added :(</h2>";
                        } else {
                            echo "<br><h2>Video Added!</h2>";
                        }
                    } else {echo "This file name is already present please rename.";}
                } else {echo "This video name is already taken please choose another one.";}
            } else {echo "This ID is already taken please choose another one.";}
        }
        ?>
            <h3>Remove Video from database</h3>
            <form method="POST" enctype="multipart/form-data">
                <select name='id' id='id'>
                <?php 
                    while($rows = $getvr->fetch_assoc()){
                        $thisidr = $rows['VideoID'];
                        $thisnamer = $rows['VideoName'];
                        $thisar = $rows['Accessebility'];
                        $thischeckr = checkViewing($thisar);
                        echo "<option value='$thisidr'>$thisidr : $thisnamer : $thischeckr</option>";
                    }
                ?><br><br>
                    <input type="submit" name="removesubmit" value="Remove">
            </form>
        <?php
            if(isset($_POST['removesubmit'])){
                $rid = $_POST['id'];
                $rvsql = "DELETE FROM `videos` WHERE(`VideoID`= '$rid')";
                if(!mysqli_query($db, $rvsql)){
                    echo "<br><h2>Video not Removed :(</h2><br>";
                } else {
                    echo "<br><h2>Video Removed!</h2><br>";}
                }
            $getav = $db->query("SELECT * FROM videos"); //Get available videos
        ?>
        <h3>Change Accessibility</h3>
        <form method="POST" enctype="multipart/form-data">
            <select name='id' id='id'>
            <?php 
                while($rows = $getav->fetch_assoc()){
                    $thisid = $rows['VideoID'];
                    $thisname = $rows['VideoName'];
                    $thisa = $rows['Accessebility'];
                    $thischeck = checkViewing($thisa);
                    echo "<option value='$thisid'>$thisid : $thisname : $thischeck</option>";
                }
            ?><br><br>
            <input type="submit" name="complementsubmit" value="Complement">
        </form>
        <?php
    
            if(isset($_POST['complementsubmit'])){
                $idtobeset = $_POST['id'];
                $getaccess = $db->query("SELECT `Accessebility` FROM `videos` WHERE `VideoID` = '$idtobeset'");
                while($row = $getaccess->fetch_assoc()){
                    $newaccess = complement($row['Accessebility']);
                }
                $sqlset = "UPDATE `videos` SET Accessebility = $newaccess WHERE `VideoID` = $idtobeset";
                $setresult = mysqli_query($db, $sqlset);
                echo "Change Made! <br>";
            }
            $out = '<table class="table" border="1"><thead><tr>';
            $viewall = "SELECT * FROM videos;";
            $result = mysqli_query($db, $viewall);
            $resultCheck = mysqli_num_rows($result);
            if($resultCheck>0){
                $out .="<th>VideoID</th><th>VideoName</th><th>Accessibility</th></tr></thead><tbody>";
                while ($row = mysqli_fetch_assoc($result)){
                    $accessCheck = $row['Accessebility'];
                    $out .="<tr><td>".$row['VideoID']."</td>";
                    $out .="<td>".$row['VideoName']."</td>";
                    $out .="<td>".checkViewing($accessCheck)."</td></tr>";
                }
                $out .="</tbody></table>";
                echo $out;
            } else {
                echo "Empty";
            }            
    }else{echo "Access denied";}

    function notExists($i, $db, $field, $table){
        $exists = "SELECT `$field` FROM `$table`";
        $r = mysqli_query($db, $exists);
        $n = mysqli_num_rows($r);
        while($x = mysqli_fetch_assoc($r)){
            if($x[$field] == $i){
                return false;
            }
        }
        return true;
    }
    function checkViewing($accessCheck){
        if($accessCheck>0){
            return "Viewing";
        } elseif($accessCheck<=0) {
            return "Not Viewing";
        }
    }
    function complement($bit){
        if($bit == 0){
            return 1;
        } else if($bit == 1){
            return 0;
        }
    }
    ?>
</body>
</html>
