<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Instructor</title>
    <link rel="stylesheet" href="http://localhost/Outershell/styles.css">
    <link rel="stylesheet" href="nav-style.css">

</head>
<body>
<form method="POST" enctype="multipart/form-data">
        Add Instructor:<br>
        Enter Instructor's Name: <input type="text" name="name"><br><br>
        Enter Instructor Description: <input type="text" name="idesc"><br><br>
        Choose an image: <input type="file" name="iimage" id="iimage"><br><br>
        <input type="submit" name="addinst" value="Add">
    </form>
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

function addInstructor($db, $name, $desc, $img){
    $db->query("INSERT INTO `instructors`(`Instructor`, `Description`, `Image`) VALUES ('$name', '$desc', '$img')");
    echo $name." added";
}

?>
</body>
</html>