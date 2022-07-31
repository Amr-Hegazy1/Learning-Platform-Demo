<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
</head>
<body>
    <?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){?>
    <form method="POST" enctype="multipart/form-data">
        Add Admin:
        <br>
        Enter a Username: <input type="text" name="username"><br><br>
        Enter a Password: <input type="text" name="password"><br><br> 
        <input type="submit" name="addsubmit" value="Add">
    </form>
    <hr>
    <?php
            include "configusers.php";
            if(isset($_POST['addsubmit'])){
                $username = $_POST["username"];
                $pass = $_POST["password"];
                $hashedpass = password_hash($pass, PASSWORD_DEFAULT);
                $addassistantsql = "INSERT INTO `admins`(`Username`,`Password`)VALUES('$username', '$hashedpass')";
                if(!mysqli_query($db, $addassistantsql)){
                    echo "<br><h2>Admin not Added :(</h2><br>";
                } else {
                    echo "<br><h2>Admin Added!</h2><br>";}
                
            }
        }else{
            echo "Access denied";
        }
    ?>
</body>
</html>