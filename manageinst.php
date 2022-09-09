<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Instructor</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="nav-style.css">

</head>
<body>
<?php include_once("nav-manager.html")?>
<div class="container manage-inst-cont">
    <div class="segment">

        <h1 class="title">Add Instructor</h1>
        <div class="line"></div>

        <form method="POST" enctype="multipart/form-data">

            <div class="name">Name</div>
            <div class="text-field">
                <input type="text" required name="name" placeholder="Enter instructor's name">
                <span></span>
            </div>

            <div class="name">Description</div>
            <div class="text-field">
                <input type="text" required name="idesc" placeholder="Enter instructor's description">
                <span></span>
            </div>

            <div class="name">Attach Image</div>
                <input type="file" id="file-button" required name="cimage" class="file-input" hidden="hidden">
                <label for="file-button" class="choose-file">
                    Choose Image :<span id="file-text">No Image Chosen</span>
                </label>
                <span></span>

            <input type="submit" name="addinst" value="Add" class="submit">
        </form>
    </div>

<?php 
session_start();
if($_SESSION['manager']){
    include "configcourses.php";
    if(isset($_POST['addinst'])){
        $name = $_POST['name'];
        $idesc = $_POST['idesc'];
        $filename = $_FILES["iimage"]["name"];
        $tempname = $_FILES["iimage"]["tmp_name"];
        $folder = "images/" . $filename;
        move_uploaded_file($tempname, $folder);
        addInstructor($dbc, $name, $idesc, $folder);
        header("Refresh:1");
    }
} else { echo "Access denied<br>"; echo '<a href="signin.php">Go Home</a><br>';}










if($_SESSION['manager']){?>
    <?php include "configcourses.php"?>



    <div class="segment">

        <h1 class="title">Remove Instructor</h1>
        <div class="line"></div>      

        <form method="POST" enctype="multipart/form-data">

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
                        echo "<li class='option'>$thisinst</li>";
                    }
                ?>  
                </ul>
            </div>

            <div id="exit-drop" class="close"></div>

            <input type="submit" name="removerec" value="Remove" class="submit">

        </form>
    </div>
</div> <!--container end -->
<?php
    if(isset($_POST['removeinst'])){
        $inst = $_POST['inst'];
        $sql = $dbc->query("DELETE FROM `instructors` WHERE `Instructor`='$inst'");
        header("Refresh:1");
    }
} else { echo "Access denied<br>"; echo '<a href="signin.php">Go Home</a><br>';}

function addInstructor($db, $name, $desc, $img){
    $db->query("INSERT INTO `instructors`(`Instructor`, `Description`, `Image`) VALUES ('$name', '$desc', '$img')");
    echo $name." added";
}

?>
<script src="chooseFile.js"></script>
<script src="dropdown.js"></script>
</body>
</html>