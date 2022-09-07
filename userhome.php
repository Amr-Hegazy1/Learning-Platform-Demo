<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
    <link rel="stylesheet" href="http://localhost/Outershell/styles/styles.css">

</head>
<body>
    <?php
        session_start();
        $loggedin = false;
        if(isset($_SESSION['loggedin'])){$loggedin = $_SESSION['loggedin'];}
        if($loggedin){
            include_once("nav-user.html");
            $u = $_SESSION['username'];
            $name = getName($u);
            echo "<h1 id='welcome'>Welcome $name!</h1>";

            ?>
            <div class="vid-cont">
                <video width="640" height="400" src = "./videos/orientation.mp4" controls></video><br>';
            </div>            
            <?php
            
        }else {
            echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';
        }

        function getName($email){
            $name = strstr($email, '@', true);
            return $name;             
        }
    ?>
</body>
</html>