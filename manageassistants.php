<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Assistant</title>
</head>
<body>
<?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){?>
    <form method="POST" enctype="multipart/form-data">
        Add Assistant:
        <br>
        Enter a Username: <input type="text" name="username"><br><br>
        Enter a Password: <input type="text" name="password"><br><br> 
        <input type="submit" name="addsubmit" value="Add">
    </form>
    <hr>
    <form method="POST" enctype="multipart/form-data">
        Remove Assistant:
        <br>
        Enter a Username: <input type="text" name="username2"><br><br> 
        <input type="submit" name="removesubmit" value="Remove">
    </form>
    <hr>
        <?php
            include "configusers.php";
            if(isset($_POST['addsubmit'])){
                $username = $_POST["username"];
                $pass = $_POST["password"];
                $hashedpass = password_hash($pass, PASSWORD_DEFAULT);
                $addassistantsql = "INSERT INTO `assistants`(`AssistantUsername`,`AssistantPassword`)VALUES('$username', '$hashedpass')";
                if(!mysqli_query($db, $addassistantsql)){
                    echo "<br><h2>Assistant not Added :(</h2><br>";
                } else {
                    echo "<br><h2>Assistant Added!</h2><br>";}
                
            }
            if(isset($_POST['removesubmit'])){
                $username2 = $_POST["username2"];
                $removeassistantsql = "DELETE FROM `assistants` WHERE(`AssistantUsername`= '$username2')";
                if(!mysqli_query($db, $removeassistantsql)){
                    echo "<br><h2>Assistant not Removed :(</h2><br>";
                } else {
                    echo "<br><h2>Assistant Removed!</h2><br>";}
            }
            $viewassistantssql = "SELECT * FROM assistants";
            $res = mysqli_query($db, $viewassistantssql);
            $resultCheck = mysqli_num_rows($res);
            if($resultCheck>0){
                while ($row = mysqli_fetch_assoc($res)){
                    echo $row['AssistantUsername'];
                    echo "<br>";            
                }
            } else {
                echo "Empty";
            }
        }else{
            echo "Access denied";
        }
        ?>
</body>
</html>