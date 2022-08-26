<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Free User</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <?php include_once("nav.html") ?>
    <?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){?>
    <div class="container" id="cont-add-admin">
        <div class="segment">
                <h1 class="title">Add User</h1>
                <div class="line"></div>
                <form method="POST" enctype="multipart/form-data">

                    <div class="name">Username</div>
                    <div class="text-field">
                        <input type="text" required name="username" id="desc" placeholder="Enter Username">
                        <span></span>
                    </div>

                    <div class="name">Password</div>
                    <div class="text-field">
                        <input type="password" required name="password" placeholder="Enter Password">
                        <span></span>
                    </div>

                    <div class="name">Confirm Password</div>
                    <div class="text-field">
                        <input type="password" required name="repassword" placeholder="Re-enter Password">
                        <span></span>
                    </div>
                    <input type="submit" name="addsubmit" value="Add" class="submit">
                </form>
        </div>
    </div>
    <?php
            include "configusers.php";
            if(isset($_POST['addsubmit'])){
                $username = $_POST["username"];
                if(notExists($username, $db, "Username", "users") && notExists($username, $db, "Username", "admins") && notExists($username, $db, "AssistantUsername", "assistants")){
                    $pass = $_POST["password"];
                    $rpass = $_POST['repassword'];
                    if($pass == $rpass){
                        if(strong($pass)){
                            if(email($username)){
                                $hashedpass = password_hash($pass, PASSWORD_DEFAULT);
                                $addassistantsql = "INSERT INTO `users`(`Username`,`Password`)VALUES('$username', '$hashedpass')";
                                $addtoprogress = $db->query("INSERT INTO `progress` (`UserID`)VALUES('$username')");
                                if(!mysqli_query($db, $addassistantsql)){
                                    echo "<div class='pop-up'>User not added</div>";
                                } else {
                                    echo "<div class='pop-up'>User added</div>";
                                    header("Refresh:1");
                                }
                            }
                        }
                    } else {echo "<div class='pop-up'>Passwords dont match</div>";}
                } else {echo "<div class='pop-up'>Username already taken, choose another one please</div>";}
            }
        }else{
                        echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';;
        }
        
        function notExists($i, $db, $field, $table){
            $exists = "SELECT `$field` FROM `$table`";
            $r = mysqli_query($db, $exists);
            $n = mysqli_num_rows($r);
            while($x = mysqli_fetch_assoc($r)){
                if($x[$field] == $i){
                    return false;
                }
            }
            return true;
        }

        function strong($password){
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                echo "<div class='pop-up'>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</div>";
                return false;
            }else{
                echo "<div class='pop-up'>Strong password.</div>";
                return true;
            }
        }

        function email($username){
            if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
                echo "<div class='pop-up'>Invalid email format</div>";
                return false;
              }
            return true;
        }
    ?>
</body>
</html>