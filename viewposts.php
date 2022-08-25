<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <?php
        include_once("nav-user.html");
        $li = false;
        session_start();
        if(isset($_SESSION['loggedin'])){
            $li = $_SESSION['loggedin'];}
        if($li){
            include "configusers.php";
            $viewpostssql = "SELECT * FROM posts ORDER BY PostID DESC";
            $res = mysqli_query($db, $viewpostssql);
            $resultCheck = mysqli_num_rows($res);
            if($resultCheck>0){
                while ($row = mysqli_fetch_array($res)){
                    echo $row['Header']."<br>";
                    echo $row['Description']."<br>";
                    $f = $row['attachments'];
                    $fn = substr($f,12);
                    if($fn == ""){
                        echo "No attachments"."<br>";
                    }
                     else {
                        ?>
                            <embed src="https://localhost/TCD/<?php echo $row['attachments'];?>" height = 400 width= 600>
                        <?php
                        echo "<br><br>";
                     }
                    echo "<br>";            
                }
            } else {
                echo "<div class='pop-up'>No posts yet</div>";
            }
        }else{
            echo "Access denied";
        }
        /*"localhost/TCD/<?php echo $row['attachments'];?>" */
    ?>
</body>
</html>