<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Instructor</title>
    <link rel="stylesheet" href="http://localhost/Outershell/styles.css">
    <link rel="stylesheet" href="nav-style.css">

</head>
<body>
<?php 
session_start();
if($_SESSION['manager']){?>
    <?php include "configcourses.php"?>
    <form method="POST" enctype="multipart/form-data">
        Choose an Instructor: <select name='inst' id='inst'>
            <?php
                $results1 = $dbc->query("SELECT * FROM `instructors`"); 
                while($eachinst = $results1->fetch_assoc()){
                    $thisinst = $eachinst['Instructor'];
                    echo "<option value='$thisinst'>$thisinst</option>";
                }
            ?>   
        </select><br><br>
        <input type="submit" name="removeinst" value="Remove">
    </form>
<?php
    if(isset($_POST['removeinst'])){
        $inst = $_POST['inst'];
        $sql = $dbc->query("DELETE FROM `instructors` WHERE `Instructor`='$inst'");
        header("Refresh:1");
    }
} else { echo "Access denied<br>"; echo '<a href="signin.php">Go Home</a><br>';}
?>
</body>
</html>