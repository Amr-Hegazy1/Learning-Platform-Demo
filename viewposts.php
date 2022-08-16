<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
</head>
<body>
    <?php
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
                echo "No Posts yet";
            }
        }else{
            echo "Access denied";
        }
        /*"localhost/TCD/<?php echo $row['attachments'];?>" */
    ?>
</body>
</html>