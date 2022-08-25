<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Video</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include_once("nav.html") ?>
    <?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){?>
        <div class="container">
            <div class="segment add-video-segment">
            <h1 class="title">Add Video</h1>
            <div class="line"></div>
            <form method="POST" enctype="multipart/form-data">

                <div class="name">Video ID</div>
                <div class="text-field">
                    <input type="number" required name="id" placeholder="Enter Video ID">
                    <span></span>
                </div>

                <div class="name">Video Name</div>
                <div class="text-field">
                    <input type="text" required name="name" placeholder="Enter Video Name">
                    <span></span>
                </div>

                <div class="name">Attach Video</div>
                    <input type="file" id="file-button" required name="file" class="file-input" hidden="hidden">
                    <label for="file-button" class="choose-file">
                        Choose File :<span id="file-text">No File Chosen</span>
                    </label>
                    <span></span>


                    <select name="accessbit" id="id" required hidden="hidden">
                    <option value="1">Available</option>
                    <option value="0">Unavailable</option>
                    </select>
                <div class="drop-down drop-down-avai" id="drop-down">
                    <div class="name" id="assign-drop">Availability : <span id="selected-drop"></span></div>
                    <div id="drop-button">▼</div>
                </div>
                <div class="options-cont avai-options" id="options">
                    <ul> 
                        <li class="option">Available</li>
                        <li class="option">Unavailable</li>
                    </ul>
                </div>
                <div id="exit-drop" class="close"></div>

                <input type="submit" name="submit" value="Add" class="submit">
            </form>
        </div>

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
                            echo "<div class='pop-up'>Video not added</div>";
                        } else {
                            echo "<div class='pop-up'>Video added</div>";
                        }
                    } else {echo "<div class='pop-up'>This file name is already present please rename</div>";}
                } else {echo "<div class='pop-up'>This video name is already taken please choose another one</div>";}
            } else {echo "<div class='pop-up'>This ID is already taken please choose another one</div>";}
        }
        ?>
    <div class="segment add-video-segment">
            <h1 class="title">Remove Video</h1>
            <div class="line"></div>
            <form method="POST" enctype="multipart/form-data">
           <select name='id' id='id2' hidden="hidden">
           <?php 
                    while($rows = $getvr->fetch_assoc()){
                        $thisidr = $rows['VideoID'];
                        $thisnamer = $rows['VideoName'];
                        $thisar = $rows['Accessebility'];
                        $thischeckr = checkViewing($thisar);
                        echo "<option value='$thisidr'>$thisidr : $thisnamer : $thischeckr</option>";
                    }
            ?>
            </select>
                <div class="drop-down" id="drop-down2">
                    <div class="name" id="assign-drop">Video ID : <span id="selected-drop2"></span></div>
                    <div id="drop-button">▼</div>
                </div>
                <div class="options-cont" id="options2">
                    <ul>
                    <?php
                        $getvr = $db->query("SELECT * FROM `videos`"); 
                        while($rows = $getvr->fetch_assoc()){
                            $thisidr = $rows['VideoID'];
                            $thisnamer = $rows['VideoName'];
                            $thisar = $rows['Accessebility'];
                            $thischeckr = checkViewing($thisar);
                            echo "<li class='option2'>$thisidr</li>";
                        }
                    ?>  
                    </ul>
                </div>
                <input type="submit" name="removesubmit" value="Remove" class="submit">
            </form>
        </div>
    </div>
        <?php
            if(isset($_POST['removesubmit'])){
                $rid = $_POST['id'];
                $rvsql = "DELETE FROM `videos` WHERE(`VideoID`= '$rid')";
                if(!mysqli_query($db, $rvsql)){
                    echo "<div class='pop-up'>Video not removed</div>";
                } else {
                    echo "<div class='pop-up'>Video removed</div>";}
                }
            $getav = $db->query("SELECT * FROM videos"); //Get available videos
        ?>
        <div class="container">
            <div class="segment add-video-segment">
                        <h1 class="title" id="change-acc">Change Accessibilty</h1>
                        <div class="line"></div>
                        <form method="POST" enctype="multipart/form-data">
                    <select name='id' id='id3' hidden="hidden">
                    <?php 
                            while($rows = $getav->fetch_assoc()){
                                $thisid = $rows['VideoID'];
                                $thisname = $rows['VideoName'];
                                $thisa = $rows['Accessebility'];
                                $thischeck = checkViewing($thisa);
                                echo "<option value='$thisid'>$thisid : $thisname : $thischeck</option>";
                            }
                        ?>
                        </select>
                            <div class="drop-down" id="drop-down3">
                                <div class="name" id="assign-drop">Video ID : <span id="selected-drop3"></span></div>
                                <div id="drop-button">▼</div>
                            </div>
                            <div class="options-cont" id="options3">
                                <ul>
                                <?php
                                    $getav = $db->query("SELECT * FROM videos");
                                    while($rows = $getav->fetch_assoc()){
                                        $thisid = $rows['VideoID'];
                                        $thisname = $rows['VideoName'];
                                        $thisa = $rows['Accessebility'];
                                        $thischeck = checkViewing($thisa);
                                        echo "<li class='option3'>$thisid</li>";
                                    }
                                ?>  
                                </ul>
                            </div>
                            <input type="submit" name="complementsubmit" value="Change" class="submit">
                        </form>
                    </div>
            </div>
        </div>
        <?php
            if(isset($_POST['removesubmit'])){
                $rid = $_POST['id'];
                $rvsql = "DELETE FROM `videos` WHERE(`VideoID`= '$rid')";
                if(!mysqli_query($db, $rvsql)){
                    echo "<div class='pop-up'>Video not removed</div>";
                } else {
                    echo "<div class='pop-up'>Video removed</div>";}
                }
            $getav = $db->query("SELECT * FROM videos"); //Get available videos
        ?>
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
            $out = '<table class="table"><thead><tr>';
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
                echo "<div class='pop-up'>Empty</div>";
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
    <script src="chooseFile.js"></script>
    <script src="dropdown-vid.js"></script>
</body>
</html>
