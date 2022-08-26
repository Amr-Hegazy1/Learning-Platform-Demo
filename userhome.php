<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <?php
        include_once("nav-user.html");
        session_start();
        $loggedin = false;
        if(isset($_SESSION['loggedin'])){$loggedin = $_SESSION['loggedin'];}

        if($loggedin){

            $u = $_SESSION['username'];
            echo "<h1 id='welcome'>Welcome $u!</h1>";

            ?>
            <div class="vid-cont">
                <video width="640" height="400" src = "./videos/orientation.mp4" controls></video><br>';
            </div>            
            <?php
            
        }else {
            echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';
        }
    ?>
</body>
</html>