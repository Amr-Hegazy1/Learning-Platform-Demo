<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Manager</title>
    <link rel="stylesheet" href="http://localhost/Outershell/styles/styles.css">

</head>
<body>
<?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){
            include_once("nav.html");
            include "configeach.php";
            $selected = $_SESSION['selected'];
            $getposts = $db->query("SELECT * FROM posts"); //Get available posts?>
    <div class="container">
    <div class="segment">
            <h1 class="title">Post</h1>
            <div class="line"></div>
            <form method="POST" enctype="multipart/form-data">

                <div class="name">Header</div>
                <div class="text-field">
                    <input type="text" required name="head" id="head" placeholder="Enter Header">
                    <span></span>
                </div>

                <div class="name">Description</div>
                <div class="text-field">
                    <input type="text" required name="description" placeholder="Enter Description">
                    <span></span>
                </div>

                <div class="name">Attachments</div>
                    <input type="file" id="file-button" name="attachment" \class="file-input" hidden="hidden">
                    <label for="file-button" class="choose-file">
                        Choose File :<span id="file-text">No File Chosen</span>
                    </label>
                    <span></span>
                <input type="submit" name="postsubmit" value="Post" class="submit">
            </form>
        </div>

        <div class="segment">
            <h1 class="title">Remove</h1>
            <div class="line"></div>
            <form method="POST" enctype="multipart/form-data">
           <select name='id' id='id' hidden="hidden">
            <?php 
            while($rows = $getposts->fetch_assoc()){
                $thisid = $rows['PostID'];
                $thishead = $rows['Header'];
                echo "<option value='$thisid'>$thisid : $thishead </option>";
            }
            ?>   
            </select>
                <div class="drop-down" id="drop-down">
                    <div class="name" id="assign-drop">Post ID : <span id="selected-drop"></span></div>
                    <div id="drop-button">▼</div>
                </div>
                <div class="options-cont" id="options">
                    <ul>
                        <?php
                        $getposts = $db->query("SELECT * FROM posts");
                            while($rows = $getposts->fetch_assoc()){
                                $thisid = $rows['PostID'];
                                $thishead = $rows['Header'];
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
        if(isset($_POST['removesubmit']) && isset($_POST['id'])){
            $id = $_POST["id"];
            removeAttach($db, $id);
            $removepostsql = "DELETE FROM `posts` WHERE(`PostID`= '$id')";
            if(!mysqli_query($db, $removepostsql)){
                echo "<div class='pop-up'>Post not removed</div>";
            } else {
                echo "<div class='pop-up'>Post removed</div>";
            }
        }
        if(isset($_POST['postsubmit'])){
            $filename ="";
            $h = $_POST['head'];
            $d = $_POST['description'];
            $filename = $_FILES["attachment"]["name"];
            $tempname = $_FILES["attachment"]["tmp_name"];
            $folder = "attachments/".$selected."/". $filename;
            if(validName($h)){
                if(validName($d)){
                    if(validType($filename)){
                        move_uploaded_file($tempname, $folder);
                        $postsql = "INSERT INTO posts(Header, Description, attachments)VALUES('$h', '$d', '$folder')";
                        if(!mysqli_query($db, $postsql)){
                            echo "<div class='pop-up'>Post not added</div>";
                        } else {
                            echo "<div class='pop-up'>Post added</div>";
                        }
                    } else {echo "<div class='pop-up'>Invalid file type. Valid file types are: pdf, jpg, png, jpeg, pptx</div>";}
                } else {echo "<div class='pop-up'>Description is empty</div>";}
            } else {echo "<div class='pop-up'>Header is empty</div>";}
        }
        $out = '<table class="table"><thead><tr>';
        $viewpostssql = "SELECT * FROM posts";
        $res = mysqli_query($db, $viewpostssql);
        $resultCheck = mysqli_num_rows($res);
        if($resultCheck>0){
            echo '<h1 class="table-title">Posts Table</h1>';
            $out .="<th>Posts ID</th><th>Header</th><th>Description</th></tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($res)){
                $out .= "<tr><td>".$row['PostID']."</td>";
                $out .= "<td>".$row['Header']."</td>";
                $out .= "<td>".$row['Description']."</td></tr>";
            }
            $out .="</tbody></table>";
            echo $out;
        } else {
            echo "<div class='pop-up'>No posts yet</div>";
        }
    }else{
            echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';;
    }

    function validName($name){
        if(strlen($name)>0){
            return true;
        }
        return false;
    }

    function validType($filename){
        if($filename != ""){
            $allowed = array('pdf', 'jpg', 'png', 'jpeg', 'pptx');
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                return false;
            }
        }
        return true;
    }

    function removeAttach($db, $id){
        $sql = $db->query("SELECT `attachments` FROM `posts` WHERE `PostID` = '$id'");
        $row = $sql->fetch_assoc();
        $loc = $row['attachments'];
        unlink($loc);
    }

        ?>
    <script src="styles/chooseFile.js"></script>
    <script src="styles/dropdown.js"></script>
</body>
</html>