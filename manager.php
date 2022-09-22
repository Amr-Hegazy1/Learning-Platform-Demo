<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Sign in</title>
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="stylesheet" href="./styles/nav-style.css">

</head>
<body>
<div class="container" id="cont-add-admin">
        <div class="segment">
        <h1 class="title">Manager Sign in</h1>
        <div class="line"></div>
    <form method="POST" enctype="multipart/form-data">

            <div class="name">Username</div>
            <div class="text-field">
                <input type="text" required name="username" id="desc" placeholder="Enter Username">
                <span></span>
            </div>

            <div class="name">Password</div>
            <div class="text-field">
                    <input type="password" required name="password" placeholder="Enter Password">
                    <span></span>
            </div>

        <input type="submit" name="loginsubmit" value="Submit" class="submit">
    </form>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['manager'])){
    echo " <script type='text/javascript'>
        window.location.href = './manageinst.php';
        </script> ";
}
else if(isset($_POST['loginsubmit'])){
    include "configcourses.php";
    $u = $_POST['username'];
    $p = $_POST['password'];
    $sql = $dbc->query("SELECT `Password` FROM `managers` WHERE `Manager`='$u'");
    if(mysqli_num_rows($sql) > 0){
        $row = $sql->fetch_assoc();
        if(password_verify($p, $row['Password'])){
            if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
            $_SESSION['manager'] = true;
            echo    '<a href="managecourses.php">Manage Courses</a>
                    <a href="manageinst.php">Manage Instructors</a>';
        }else{echo "Incorrect credentials";header("Refresh:1");}
    } else {echo "Incorrect credentials";}
}
?>
</body>
</html>