<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Log in</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        Username: <input type="text" name="username"> bye <br><br> 
        Password: <input type="text" name="password"> bye <br><br>
        <input type="submit" name="loginsubmit" value="Submit">
    </form>
    <?php
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
                echo "Correct";
                echo "<br>";
                $loggedin = true;
                $_SESSION['adminloggedin'] = $loggedin;
                echo '<a href="http://localhost/TCD/addadmin.php"> Add Admin </a><br>';
                echo '<a href="http://localhost/TCD/addtest.php"> Add Video </a><br>';
                echo '<a href="http://localhost/TCD/manageassignments.php"> Manage Assignments </a><br>';
                echo '<a href="http://localhost/TCD/manageassistants.php"> Manage Assistants </a><br>';
                echo '<a href="http://localhost/TCD/manageposts.php"> Manage Posts </a><br>';
                echo '<a href="http://localhost/TCD/manageviewing.php"> Manage Viewing </a><br>';
            }else {
                echo "Wrong";
                $loggedin = false;
                $_SESSION['adminloggedin'] = $loggedin;
            }
        }
    ?>
</body>
</html>