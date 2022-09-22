<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/nav-style.css">


</head>
<body>

<div class="container" id="signin-cont">
    
    <div class="segment" id="signin-seg">
        <h1 class="title">Sign in</h1>
        <div class="line"></div>
        <form method="POST" enctype="multipart/form-data">

                <div class="name">Username</div>
                <div class="text-field">
                    <input type="text" required name="username" id="desc" placeholder="Enter Username">
                    <span></span>
                </div>

                <div class="name bottom-name">Password</div>
                <div class="text-field">
                        <input type="password" required name="password" placeholder="Enter Password">
                        <span></span>
                </div>

    

                <div class="center" id="signup-dir">Not a member?<a href="signup.php">Sign up</a></div>

            <input type="submit" name="loginsubmit" value="Sign in" class="submit">
        </form>
    </div>
</div>
<?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']){
            echo " <script type='text/javascript'>
            window.location.href = './userhome.php';
            </script> ";
        }else if(isset($_SESSION['assistantloggedin']) && $_SESSION['assistantloggedin']){
            echo " <script type='text/javascript'>
            window.location.href = './assistanthome.php';
            </script> ";
        }else if (isset($_SESSION['adminloggedin']) && $_SESSION['adminloggedin']){
            echo " <script type='text/javascript'>
            window.location.href = './adminhome.php';
            </script> ";
        }
        include "configeach.php"; 
        if(isset($_POST['loginsubmit'])){
            $u = $_POST['username'];
            $p = $_POST['password'];
            $adminloginsql = $db->query("SELECT `Password` FROM `admins` WHERE `Username` = '$u' ");
            $assistantloginsql = $db->query("SELECT `AssistantPassword` FROM `assistants` WHERE `AssistantUsername` = '$u' ");
            $userloginsql = $db->query("SELECT `Password` FROM `users` WHERE `Username` = '$u' AND `paid` = 1");
            if(mysqli_num_rows($userloginsql) > 0){
                $r = $userloginsql->fetch_assoc();
                if(password_verify($p, $r['Password'])){
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $u;
                    header("Location:./userhome.php");
                    exit();
                }
            } else {
                if(mysqli_num_rows($assistantloginsql) > 0){
                    $r = $assistantloginsql->fetch_assoc();
                    if(password_verify($p, $r['AssistantPassword'])){
                        $_SESSION['assistantloggedin'] = true;
                        $_SESSION['assistant'] = $u;
                        header("Location:./assistanthome.php");
                        exit();
                    }
                } else {
                    if(mysqli_num_rows($adminloginsql) > 0){
                        $r = $adminloginsql->fetch_assoc();
                        if(password_verify($p, $r['Password'])){
                            $_SESSION['adminloggedin'] = true;
                            $_SESSION['admin'] = $u;
                            header("Location:./adminhome.php");
                            exit();

                        }
                    }}}
            
            echo "<div class='pop-up'>Invalid Username or Password</div>";
        }
    ?>
    
</body>
</html>
