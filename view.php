<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Videos</title>
    <!--<link rel="stylesheet" href="styles.css">-->

</head>
<body>
<?php include_once("nav-user.html"); ?>
    <?php
        $li = false;
        session_start();
        if(isset($_SESSION['loggedin'])){
            $li = $_SESSION['loggedin'];}
        if($li){

            include "configusers.php";

            $viewsql = "SELECT * FROM `videos` WHERE `Accessebility`= 1 ORDER BY VideoID DESC";
            $res = mysqli_query($db, $viewsql);

            if(mysqli_num_rows($res)>0){

                while ($video = mysqli_fetch_assoc($res)){

                    $name = $video['VideoName'];
                    $loc = $video['VideoLocation'];
                    echo "$name ";
                    
                    ?>
                        <div class="vid-cont">
                        <video width="640" height="560" src="http://localhost/TCD/<?=$loc?>" controls></video><br>
                        </div>          

                    <?php            
                }
            } else {
                echo "<div class='pop-up'>No videos yet</div>";
            }
        }else{
            echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';;
        }
    ?>
</body>
</html>