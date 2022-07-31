<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistant Log in</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        Log in:
        <br>
        Enter a Username: <input type="text" name="username"><br><br>
        Enter a Password: <input type="text" name="password"><br><br> 
        <input type="submit" name="loginsubmit" value="Log in">
    </form>
    <?php
        include "configusers.php";
        if(isset($_POST['loginsubmit'])){
            $username = $_POST["username"];
            $password = $_POST["password"];
            $assistantloginsql = "SELECT AssistantPassword FROM assistants WHERE AssistantUsername = '$username' ";
            $res = mysqli_query($db, $assistantloginsql);
            $resultCheck = mysqli_num_rows($res);
            $row = mysqli_fetch_assoc($res);
            if($resultCheck>0){
                if(password_verify($password, $row['AssistantPassword'])){
                    echo "Password Correct";
                } else {
                    echo "Incorrect Username or Password";
                }
        }       }
    ?>
</body>
</html>

