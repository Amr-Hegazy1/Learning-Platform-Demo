<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Viewing of Videos</title>
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
        Accessibility: <input type="number" name="accessbit"> Enter 1 for True and 0 for False<br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
    <?php
        include "newconfig.php";
        if(isset($_POST['submit'])){
            $idtobeset = $_POST['id'];
        $newaccess = $_POST['accessbit'];
        $sqlset = "UPDATE `videos` SET Accessebility = $newaccess WHERE `VideoID` = $idtobeset";
            $setresult = mysqli_query($db, $sqlset);
            echo "Change Made! <br>";
        }
        $viewall = "SELECT * FROM videos;";
        $result = mysqli_query($db, $viewall);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck>0){
            while ($row = mysqli_fetch_assoc($result)){
                $accessCheck = $row['Accessebility'];
                echo $row['VideoID'];
                echo "<-->";
                echo $row['VideoName'];
                echo "<-->";
                checkViewing($accessCheck);
                /*echo $row['Accessebility'];*/
                echo "<br>";            
            }
        } else {
            echo "Empty";
        }
    }else{
        echo "Access denied";
    }
    function checkViewing($accessCheck){
        if($accessCheck>0){
            echo "Viewing";
        } elseif($accessCheck<=0) {
            echo "Not Viewing";
        }
    }
    ?>
</body>
</html>