<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistant Log in</title>
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
            $p = $_POST['password'];
            $assistantloginsql = "SELECT AssistantPassword FROM assistants WHERE AssistantUsername = '$u' ";
            $res = mysqli_query($db, $assistantloginsql);
            $row = mysqli_fetch_assoc($res);
            if(password_verify($p, $row['AssistantPassword'])){
                echo "Correct";
                echo "<br>";
                $loggedin = true;
                $_SESSION['loggedin'] = $loggedin;
                echo '<a href="http://localhost/TCD/viewwork.php"> Start Correcting!    </a>';
            }else {
                echo "Wrong";
                $loggedin = false;
                $_SESSION['loggedin'] = $loggedin;
            }
        }
    ?>
</body>
</html>