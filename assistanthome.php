<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistant Home</title>
</head>
<body>
    <?php
        include "configusers.php";
        $loggedin = false;
        if(isset($_POST['loginsubmit'])){
            echo "<h1>Assistant Home</h1>";
            session_start();  //Start or Resume
            $u = $_POST['username'];
            $p = $_POST['password'];
            $_SESSION['assistant'] = $u; 
            echo "<h6>Welcome $u</h6><hr>";
            $assistantloginsql = "SELECT AssistantPassword FROM assistants WHERE AssistantUsername = '$u' ";
            $res = mysqli_query($db, $assistantloginsql);
            $row = mysqli_fetch_assoc($res);
            if(password_verify($p, $row['AssistantPassword'])){
                $loggedin = true;
                $_SESSION['assistantloggedin'] = $loggedin;
                echo '<a href="http://localhost/TCD/viewwork.php"> Start Correcting!</a><br>';
                echo '<a href="http://localhost/TCD/answerquestions.php"> Answer Questions!</a><br>';
                echo '<a href="http://localhost/TCD/changemyanswer.php"> Change or Delete my Answers</a><br>';

            }else {
                $_SESSION['assistantloggedin'] = $loggedin;
            }
        }
        if(!$loggedin){
    ?>
        <form method="POST" enctype="multipart/form-data">
        Username: <input type="text" name="username"><br><br>
        Password: <input type="text" name="password"><br><br>
        <input type="submit" name="loginsubmit" value="Submit">
    </form>
    <?php }?>
</body>
</html>