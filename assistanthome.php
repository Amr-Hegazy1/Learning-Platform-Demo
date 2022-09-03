<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistant Home</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <?php
        include_once("nav-assistant.html");
        session_start();
        $loggedin = false;
        if(isset($_SESSION['assistantloggedin'])){$loggedin = $_SESSION['assistantloggedin'];}
        if($loggedin){
            $u = $_SESSION['assistant'];
            echo "<h1 id='welcome'>Welcome $u!</h1>";
            echo "<div id='welcome-desc'>
                    Here is a quick tutorial to show you around
                </div>";
            echo "<div class='vid-cont'>
                <video width='640' height='400' src = './videos/orientation.mp4' controls></video><br>';
            </div>";
        }else {
            echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';

        }
    ?>
</body>
</html>