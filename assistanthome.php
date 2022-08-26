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
        }else {
            echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';

        }
    ?>
</body>
</html>