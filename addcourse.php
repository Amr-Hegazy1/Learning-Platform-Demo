<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="http://localhost/Outershell/styles.css">
    <link rel="stylesheet" href="nav-style.css">

</head>
<body>
    <?php include "configcourses.php"?>
    <form method="POST" enctype="multipart/form-data">
        Add Course:
        <br>
        Enter a Title: <input type="text" name="title"><br><br>
        Enter a  First Description Paragraph: <input type="text" name="desc1"><br><br>
        Enter a  Second Description Paragraph: <input type="text" name="desc2"><br><br>
        Enter a  Third Description Paragraph: <input type="text" name="desc3"><br><br>
        Choose an Instructor: <select name='inst' id='inst'>
            <?php
                $results1 = $dbc->query("SELECT * FROM `instructors`"); 
                while($eachinst = $results1->fetch_assoc()){
                    $thisinst = $eachinst['Instructor'];
                    echo "<option value='$thisinst'>$thisinst</option>";
                }
            ?>   
        </select><br><br>
        Choose a database: <select name='d' id='d'>
        <?php
            $a = getAvailableDatabases($db);
            for($i=0; $i<count($a);$i++){
                echo "<option value='$a[$i]'>$a[$i]</option>";
            }
        ?>
        </select>
        <br><br>Enter a Price: <input type="number" name="price"><br><br> 
        Choose an image: <input type="file" name="cimage" id="cimage"><br><br>
        <input type="submit" name="addsubmit" value="Add">
    </form>
<?php 
session_start();
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
</body>
</html>