<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Log in</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        Username: <input type="text" name="username"><br><br>
        Password: <input type="text" name="password"><br><br>
        <input type="submit" name="loginsubmit" value="Submit">
    </form>
    <?php
        include "configusers.php";
        if(isset($_POST['loginsubmit'])){
            session_start();  //Start or Resume
            $u = $_POST['username'];
            $_SESSION['username'] = $u;
            $p = $_POST['password'];
            $userloginsql = "SELECT Password FROM users WHERE Username = '$u' ";
            $res = mysqli_query($db, $userloginsql);
            $row = mysqli_fetch_assoc($res);
            if(($row['Password'])==($p)){
                echo "Correct";
                echo "<br>";
                $loggedin = true;
                $_SESSION['loggedin']=$loggedin;
                echo '<a href="http://localhost/TCD/view.php"> Stream    </a>';
                echo '<a href="http://localhost/TCD/submitassignment.php"> Assignments    </a>';
                echo '<a href="http://localhost/TCD/viewposts.php/"> Posts    </a>';
                echo '<hr>';
                echo '<br>';
                echo '<br>';
                echo '<br>';
                ?>
                <video src = "http://localhost/TCD/videos/orientation.mp4" controls></video><br>';
                <?php
            }else {
                echo "Wrong";
                $loggedin = false;
                $_SESSION['loggedin']=$loggedin;
            }
        }
    ?>
</body>
</html>