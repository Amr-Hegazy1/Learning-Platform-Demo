<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
</head>
<body>
    <?php
        $loggedin = false;
        include "configusers.php";
        if(isset($_POST['loginsubmit'])){
            session_start();  //Start or Resume
            $u = $_POST['username'];
            $p = $_POST['password'];
            $_SESSION['admin'] = $u;
            $adminloginsql = "SELECT `Password` FROM `admins` WHERE `Username` = '$u' ";
            $res = mysqli_query($db, $adminloginsql);
            $row = mysqli_fetch_assoc($res);
            if(password_verify($p, $row['Password'])){
                echo "<h1>Dashboard</h1>";
                echo "<h6>Welcome $u</h6><hr>";
                $loggedin = true;
                $_SESSION['adminloggedin'] = $loggedin;
                echo '<a href="./addadmin.php"> Add Admin </a><br>';
                echo '<a href="./managevideos.php"> Manage Videos </a><br>';
                echo '<a href="./manageassignments.php"> Manage Assignments </a><br>';
                echo '<a href="./manageassistants.php"> Manage Assistants </a><br>';
                echo '<a href="./manageposts.php"> Manage Posts </a><br>';
                echo '<a href="./managequestions.php"> Manage Questions </a><br>';
                echo '<a href="./addfreeuser.php"> Add Free User </a><br>';
                echo '<a href="./adminanswer.php"> Answer Questions </a><br>';
                echo '<a href="./viewprogress.php"> View Progress </a><br>';
                ?>
                    <video width="640" height="400" src = "./videos/orientation.mp4" controls></video><br>';
                <?php
            }else {
                $loggedin = false;
                $_SESSION['adminloggedin'] = $loggedin;
            }
        }
        if(!$loggedin){
    ?>
        <form method="POST" enctype="multipart/form-data">
            Username: <input type="text" name="username"> bye <br><br> 
            Password: <input type="text" name="password"> bye <br><br>
        <input type="submit" name="loginsubmit" value="Submit">
        </form>
        <?php }?>
</body>
</html>