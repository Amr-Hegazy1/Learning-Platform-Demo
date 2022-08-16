<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
</head>
<body>
    <?php
        include "configusers.php";
        $loggedin = false;
        if(isset($_POST['loginsubmit'])){
            echo "<h1>User Home</h1>";
            session_start();  //Start or Resume
            $u = $_POST['username'];
            $_SESSION['username'] = $u;
            $p = $_POST['password'];
            $userloginsql = "SELECT Password FROM users WHERE Username = '$u' ";
            $res = mysqli_query($db, $userloginsql);
            $row = mysqli_fetch_assoc($res);
            if(password_verify($p, $row['Password'])){
                echo "<h6>Welcome $u</h6><hr>";
                echo "<br>";
                $loggedin = true;
                $_SESSION['loggedin']=$loggedin;
                echo '<a href="http://localhost/TCD/view.php">Stream</a><br>';
                echo '<a href="http://localhost/TCD/submitassignment.php">Assignments</a><br>';
                echo '<a href="http://localhost/TCD/viewposts.php/">Posts</a><br>';
                echo '<a href="http://localhost/TCD/askquestion.php/">Ask Questions</a><br>';
                echo '<a href="http://localhost/TCD/viewquestions.php/">View Questions</a><br>';
                echo '<a href="http://localhost/TCD/viewreturns.php/">View Returns</a><br>';
                echo '<hr>';
                ?>
                <video width="640" height="400" src = "http://localhost/TCD/videos/orientation.mp4" controls></video><br>';
                <?php
            }else {
                echo "Wrong";
                $loggedin = false;
                $_SESSION['loggedin']=$loggedin;
            }
        }
        if(!$loggedin){
    ?>
        <form method="POST" enctype="multipart/form-data">
            <h1>Log in:</h1>
            Username: <input type="text" name="username"><br><br>
            Password: <input type="text" name="password"><br><br>
        <input type="submit" name="loginsubmit" value="Submit">
    </form>
    <?php }?>
</body>
</html>