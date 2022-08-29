<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
<?php include_once("nav.html") ?>

    <?php
        session_start();
        $loggedin = false;
        if(isset($_SESSION['adminloggedin'])){$loggedin = $_SESSION['adminloggedin'];}
        if($loggedin){
            $u = $_SESSION['admin'];
            echo "<h1 id='welcome'>Welcome $u!</h1>";
            ?>
                <div id="welcome-desc">
                    Here is a quick tutorial to show you around
                </div>
                    <div class="vid-cont">
                        <video width="640" height="400" src = "./videos/orientation.mp4" controls></video><br>';
                    </div>
            <?php
            }else {
                echo "Access Denied<br>";
                echo '<a href="signin.php">Go Home</a>';

            }
            
    ?>
</body>
</html>