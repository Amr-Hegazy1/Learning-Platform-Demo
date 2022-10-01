<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="stylesheet" href="./styles/nav-style.css">

</head>
<body>
    <?php
     try{
        $li = false;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION['loggedin'])){
            $li = $_SESSION['loggedin'];}
        if($li){
            include_once("nav-user.html");
            echo "<h1 class='center-header'>Posts</h1><hr>";
            include "configeach.php";
            $viewpostssql = "SELECT * FROM `posts` ORDER BY `PostID` DESC";
            $res = mysqli_query($db, $viewpostssql);
            $resultCheck = mysqli_num_rows($res);
            if($resultCheck>0){
                echo  "<div class='posts-container'>";
                while ($row = mysqli_fetch_array($res)){
                    echo "<div class='qa-cont post-cont'>";
                    echo "<h2 class='post-title'>".$row['Header']."</h2>";
                    echo "<hr>";
                    echo "<div class='post-desc'>".$row['Description']."</div>";
                    $f = $row['attachments'];
                    $fn = substr($f,15);
                    if($fn == ""){
                    }
                     else {
                        echo '<div class="view-cont"><a href="./'.$row['attachments'].'">View Attachments</a></div>';
                    }
                    echo "</div>";  
                }
                echo "</div>";  
            } else {
                echo "<div class='pop-up'>No posts yet</div>";
            }
        }else{
            echo "Access denied<br>";
            echo '<a href="index.php">Go Home</a><br>';;
        }
    }catch( Error $ex){
        echo $ex;
    }catch(Exception $ex){
        echo $ex;
    }
    ?>
</body>
</html>