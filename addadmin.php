<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Add Admin</title>
</head>
<body>
    <?php include_once("nav.html") ?>
    <?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){
    ?>
    <div class="container" id="cont-add-admin">
        <div class="segment">
                <h1 class="title">Add Admin</h1>
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
                $pass = $_POST["password"];
                $rpass = $_POST['repassword'];
                if(notExists($username, $db)){
                    if($pass == $rpass){
                        $hashedpass = password_hash($pass, PASSWORD_DEFAULT);
                        $addassistantsql = "INSERT INTO `admins`(`Username`,`Password`)VALUES('$username', '$hashedpass')";
                        if(!mysqli_query($db, $addassistantsql)){
                            echo "<div class='pop-up'>Admin not added</div>";
                        } else {
                            echo "<div class='pop-up'>Admin added</div>";}
                    } else {
                        echo "<div class='pop-up'>Passwords Dont Match</div>";
                    }
                } else {
                    echo "<div class='pop-up'>Username already exists</div>";
                }
            }
        }else{
            echo "Access denied";
        }
        function notExists($name, $db){
            $exists = "SELECT `Username` FROM `admins`";
            $r = mysqli_query($db, $exists);
            $n = mysqli_num_rows($r);
            while($x = mysqli_fetch_assoc($r)){
                if($x['Username'] == $name){
                    return false;
                }
            }
            return true;
        }
    ?>
</body>
</html>