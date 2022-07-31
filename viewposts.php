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
            $viewpostssql = "SELECT * FROM posts";
            $res = mysqli_query($db, $viewpostssql);
            $resultCheck = mysqli_num_rows($res);
            if($resultCheck>0){
                while ($row = mysqli_fetch_assoc($res)){
                    echo $row['PostID'];
                    echo $row['Header'];
                    echo $row['Description'];
                    echo "<br>";            
                }
            } else {
                echo "Empty";
            }
        }else{
            echo "Access denied";
        }

    ?>
</body>
</html>