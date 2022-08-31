<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Platform</title>
    <link rel="stylesheet" href="http://localhost/TCD/styles.css">
    <link rel="stylesheet" href="http://localhost/TCD/nav-style.css">
    <link rel="icon" href="http://localhost/TCD/images/icon.jpg">


</head>
<body>
<a href="signin.php">Log in</a><br>
<div class="container">
    <div class="segment add-video-segment">
        <h1 class="title">Sign Up</h1>
        <div class="line"></div>
        <form method="POST" enctype="multipart/form-data">

            <div class="name">E-mail</div>

                <div class="text-field">
                    <input type="text" required name="username" placeholder="Enter a valid E-mail. This will be your username">
                    <span></span>
                </div>

            <div class="name">First Name</div>

                <div class="text-field">
                    <input type="text" required name="fname" placeholder="Enter your First Name">
                    <span></span>
                </div>
            
            <div class="name">Last Name</div>

                <div class="text-field">
                    <input type="text" required name="lname" placeholder="Enter your Last Name">
                    <span></span>
                </div>

            <select name="gender" id="gender" required>
                <option value="1">M</option>
                <option value="0">F</option>
            </select>

            <div class="name">Student's Phone Number</div>

                <div class="text-field">
                    <input type="text" required name="snumber" placeholder="Enter Student's Phone Number">
                    <span></span>
                </div>

            <div class="name">Parent's Phone Number</div>

                <div class="text-field">
                    <input type="text" required name="pnumber" placeholder="Enter Parent's Phone Number">
                    <span></span>
                </div>

            <div class="name">School</div>

                <div class="text-field">
                    <input type="text" required name="school" placeholder="Enter your school. No abbreviations please">
                    <span></span>
                </div>

            <div class="name">Password</div>

                <div class="text-field">
                    <input type="password" required name="password" placeholder="Enter a password">
                    <span></span>
                </div>

            <div class="name">Re-enter password</div>

                <div class="text-field">
                    <input type="password" required name="rpassword" placeholder="Re-enter the password">
                    <span></span>
                </div>

            <input type="submit" name="add" value="Proceed to checkout" class="submit">
        </form>
    </div>
</div>

<?php
    include "configusers.php";
    if(isset($_POST['add'])){
        $username = $_POST['username'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $gender = $_POST['gender'];
        $snumber = $_POST['snumber'];
        $pnumber = $_POST['pnumber'];
        $school = $_POST['school'];
        $pass = $_POST['password'];
        $repass = $_POST['rpassword'];
        if(notExists($username, $db, "Username", "users") && notExists($username, $db, "Username", "admins") && notExists($username, $db, "AssistantUsername", "assistants")){
            if($pass == $repass){
                if(strong($pass)){
                    if(email($username)){
                        $hpass = password_hash($pass, PASSWORD_DEFAULT);
                        $sql = $db->query("INSERT INTO `users`(`Username`, `Password`, `first name`, `last name`, `gender`, `school`, `phone no`, `parentphone`) VALUES ('$username', '$hpass', '$fname', '$lname', '$gender', '$school', '$snumber', '$pnumber')");
                        header("Location:signin.php");                  
                    }
                }
            } else {echo "<div class='pop-up'>Passwords don't match</div>";}
        } else {echo "<div class='pop-up'>Invalid E-mail</div>";}
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