<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Admin Home</title>
</head>
<body>

    <?php include_once("nav.html")?>
    <?php
        $loggedin = false;
        include "configusers.php";
        if(isset($_POST['loginsubmit'])){
            $u = $_POST['username'];
            $p = $_POST['password'];
            $_SESSION['admin'] = $u;
            $adminloginsql = "SELECT `Password` FROM `admins` WHERE `Username` = '$u' ";
            $res = mysqli_query($db, $adminloginsql);
            $row = mysqli_fetch_assoc($res);
            if(password_verify($p, $row['Password'])){
                echo "<h1 id='welcome'>Welcome $u!</h1>";
                $loggedin = true;
                $_SESSION['adminloggedin'] = $loggedin;
                ?>
                <div id="welcome-desc">
                    Here is a quick tutorial to show you around
                </div>
                    <div class="vid-cont">
                        <video width="640" height="400" src = "./videos/orientation.mp4" controls></video><br>';
                    </div>
                <?php
            }else {
                $loggedin = false;
                $_SESSION['adminloggedin'] = $loggedin;
            }
        }
        if(!$loggedin){
    ?>
        <div class="container center">
        <div class="segment" id="login-seg">
                <h1 class="title">Login</h1>
                <div class="line"></div>
                <form method="POST" enctype="multipart/form-data">

                    <div class="name">Username</div>
                    <div class="text-field">
                        <input type="text" required name="username" placeholder="Enter Username">
                        <span></span>
                    </div>

                    <div class="name">Password</div>
                    <div class="text-field">
                        <input type="password" required name="password" placeholder="Enter Password">
                        <span></span>
                    </div>

                    <input type="submit" name="loginsubmit" value="Login" class="submit">
                </form>
        </div>
    </div>
    <!--
        <form method="POST" enctype="multipart/form-data">
            Username: <input type="text" name="username"> bye <br><br> 
            Password: <input type="text" name="password"> bye <br><br>
        <input type="submit" name="loginsubmit" value="Submit">
        </form>
        -->
        <?php }?>
</body>
</html>