<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistant Home</title>
    <link rel="stylesheet" href="./styles/styles.css">

</head>
<body>
    <?php
        if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
        $loggedin = false;
        if(isset($_SESSION['assistantloggedin'])){$loggedin = $_SESSION['assistantloggedin'];}
        if($loggedin){
            include_once("nav-assistant.html");
            $u = $_SESSION['assistant'];
            $name = getName($u);
            echo "<h1 id='welcome'>Welcome $name!</h1>";
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