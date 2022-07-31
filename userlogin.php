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
            $username = $_POST["username"];
            $password = $_POST["password"];
            $userloginsql = "SELECT Password FROM users WHERE Username = '$username' ";
            $res = mysqli_query($db, $userloginsql);
            $row = mysqli_fetch_assoc($res);
            if(($row['Password'])==($password)){
                echo "Correct";
                $loggedin = true;
            }else {
                echo "Wrong";
                $loggedin = false;
            }       
        }
    ?>
    </body>
    </html>