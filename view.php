<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Videos</title>
</head>
<body>
    <?php include_once("nav-user.html"); ?>
    <?php
        $li = false;
        session_start();
        if(isset($_SESSION['loggedin'])){
            $li = $_SESSION['loggedin'];
            include "configusers.php";}
        if($li){
            $viewsql = "SELECT * FROM videos WHERE `Accessebility`= 1 ORDER BY VideoID DESC";
            $res = mysqli_query($db, $viewsql);
            if(mysqli_num_rows($res)>0){
                while ($video = mysqli_fetch_assoc($res)){
                    $name = $video['VideoName'];
                    echo "$name ";
                ?>
                    <video width="640" height="560" src="http://localhost/TCD/<?=$video['VideoLocation']?>" controls></video><br>
                <?php            
                }
            } else {
                echo "<div class='pop-up'>No videos yet</div>";
            }
        }else{
            echo "Access Denied";
        }
    ?>
</body>
</html>