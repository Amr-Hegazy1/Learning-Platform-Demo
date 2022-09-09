<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Sign in</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <?php include_once("nav-manager.html")?>
<div class="container center">
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

if(isset($_POST['loginsubmit'])){
    include "configcourses.php";
    $u = $_POST['username'];
    $p = $_POST['password'];
    $sql = $dbc->query("SELECT `Password` FROM `managers` WHERE `Manager`='$u'");
    if(mysqli_num_rows($sql) > 0){
        $row = $sql->fetch_assoc();
        if(password_verify($p, $row['Password'])){
            session_start();
            $_SESSION['manager'] = true;
            // echo    '<a href="addcourse.php">Add Course</a>
            //         <a href="addinst.php">Add Instructor</a>
            //         <a href="removecourse.php">Remove Course</a>
            //         <a href="removeinst.php">Remove Instructor</a>';
        }else{echo "Incorrect credentials";header("Refresh:1");}
    } else {echo "Incorrect credentials";}
}
?>
</body>
</html>