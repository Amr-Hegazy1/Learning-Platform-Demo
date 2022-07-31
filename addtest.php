<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Video</title>
</head>
<body>
    <?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){?>
    <form method="POST" enctype="multipart/form-data">
        Video ID: <input type="number" name="id"><br><br>
        Video Name: <input type="text" name="name"><br><br>
        Attach Video from Here: <input type='file' name='file' id='file'><br><br> 
        Accessibility: <input type="number" name="accessbit"> Enter 1 for True and 0 for False<br><br>
        <input type="submit" name="submit" value="submit">
    </form>
    <?php
        include "newconfig.php";
        if(isset($_POST['submit'])){
            $testid = $_POST["id"];
            $testname = $_POST["name"];
            $testaccessbit = $_POST["accessbit"];
            $filename = $_FILES["file"]["name"];
            $tempname = $_FILES["file"]["tmp_name"];
            $folder = "videos/" . $filename;
            move_uploaded_file($tempname, $folder);
            $sql = "INSERT INTO `videos`(`VideoID`,`VideoName`,`VideoLocation`,`Accessebility`)VALUES('$testid', '$testname', '$folder', '$testaccessbit')";
            if(!mysqli_query($db, $sql)){
                echo "<br><h2>Video not Added :(</h2>";
            } else {
                echo "<br><h2>Video Added!</h2>";
            }
        }
    }else{
        echo "Access denied";
    }
    ?>
</body>
</html>
