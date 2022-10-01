<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
    <link rel="stylesheet" href="./styles/styles.css">

</head>
<body>
    <?php
     try{
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $loggedin = false;
        if(isset($_SESSION['loggedin'])){$loggedin = $_SESSION['loggedin'];}
        if($loggedin){
            include_once("nav-user.html");
            $u = $_SESSION['username'];
            $name = getName($u);
            $selected = $_SESSION['selected'];
            echo "<h1 id='welcome'>Welcome $name!</h1><div id='welcome-desc'>Here is a quick tutorial to show you around</div>";

            ?>
            <div class="vid-cont">
                <video width="640" height="400" src = "./videos/<?php echo $selected ?>/userorientation.mp4" controls></video><br>';
            </div>            
            <?php
            
        }else {
            echo "Access denied<br>";
            echo '<a href="index.php">Go Home</a><br>';
        }

        
    }catch( Error $ex){
        echo $ex;
    }catch(Exception $ex){
        echo $ex;
    }
    ?>
    <?php
    
    function getName($email){
        $name = strstr($email, '@', true);
        return $name;             
    }
    
    ?>
</body>
</html>