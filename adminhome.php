<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="http://localhost/Outershell/styles/styles.css">

</head>
<body>
    <?php
        session_start();
        $loggedin = false;
        if(isset($_SESSION['adminloggedin'])){$loggedin = $_SESSION['adminloggedin'];}
        if($loggedin){
            include_once("nav.html");
            $u = $_SESSION['admin'];
            $selected = $_SESSION['selected'];
            $name = getName($u);
            echo "<h1 id='welcome'>Welcome $name!</h1>";
            ?>
                <div id="welcome-desc">
                    Here is a quick tutorial to show you around
                </div>
                    <div class="vid-cont">
                        <video width="640" height="400" src = "./videos/<?php echo $selected ?>/adminorientation.mp4" controls></video><br>';
                    </div>
            <?php
        }else {
            echo "Access Denied<br>";
            echo '<a href="signin.php">Go Home</a>';

        }

        function getName($email){
            $name = strstr($email, '@', true);
            return $name;             
        }
            
    ?>
</body>
</html>