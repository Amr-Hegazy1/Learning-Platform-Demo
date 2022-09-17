<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Manager</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body><?php 
$ali = false;
session_start();
if(isset($_SESSION['adminloggedin'])){
    $ali = $_SESSION['adminloggedin'];}
if($ali == true){
    include_once("nav.html");
    include "configusers.php";
    ?>
    <div class="container-manage-user">
    <div class="container" id="cont-add-admin">
    <div class="segment single-seg add-user-seg signup-seg">
            <h1 class="title">Add User</h1>
            <div class="line"></div>
            <form method="POST" enctype="multipart/form-data">
            <div class="add-user-cont">

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


                <select name="gender" id="id" required hidden="hidden">
                    <option value="M">M</option>
                    <option value="F">F</option>
                </select>

                <div class="drop-down" id="drop-down">
                    <div class="name gender-manage" id="assign-drop">Gender: <span id="selected-drop"></span></div>
                    <div id="drop-button">▼</div>
                </div>

                <div class="options-cont wide-options" id="options">
                    <ul>
                        <li class='option'>Male</li>
                        <li class='option'>Female</li>
                    </ul>
                </div>

                <div id="exit-drop" class="close"></div>


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
                
                <div class="name">E-mail</div>

                    <div class="text-field">
                        <input type="text" required name="username" placeholder="Enter a valid E-mail. This will be your username">
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

                </div>
                <input type="submit" name="add" value="Add" class="submit">
            </form>
        </div>
    </div>

    <div class="container center">
        <div class="segment add-user-seg-bottom">

            <h1 class="title">Remove User</h1>
            <div class="line"></div>      

            <form method="POST" enctype="multipart/form-data">

                <select name='username2' id='id2' hidden="hidden">

                    <?php
                        $getvr = $db->query("SELECT * FROM `users`");
                        while($rows = $getvr->fetch_assoc()){
                            $thisidr = $rows['Username'];
                            $thisnamer = $rows['first name'];
                            $thisar = $rows['last name'];
                            echo "<option value='$thisidr'>$thisidr</option>";
                        }
                    ?>

                </select>

                <div class="drop-down" id="drop-down2">
                    <div class="name" id="assign-drop">Username : <span id="selected-drop2"></span></div>
                    <div id="drop-button">▼</div>
                </div>

                <div class="options-cont wide-options" id="options2">
                    <ul>
                    <?php
                        $getvr = $db->query("SELECT * FROM users"); 
                        while($rows = $getvr->fetch_assoc()){
                            $thisidr = $rows['Username'];
                            echo "<li class='option2'>$thisidr</li>";
                        }
                    ?>  
                    </ul>
                </div>

                <div id="exit-drop" class="close"></div>


                <input type="submit" name="remove" value="Remove" class="submit">

            </form>
        </div>
    </div>
</div>
    <?php
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
                            echo "<div class='pop-up'>User Added</div>";
                        }
                    }
                } else {echo "<div class='pop-up'>Passwords don't match</div>";}
            } else {echo "<div class='pop-up'>Invalid E-mail</div>";}
        }

        if(isset($_POST['remove'])){
            $user = $_POST['id'];
            $sqlr = $db->query("DELETE FROM `users` WHERE `Username` = '$user'");
            echo "User Removed";
        }
        echo "<h1 class='table-title'>Users Table</h1>
        <hr>";
        $out = '<div class="table-cont">
        <table class="table"><thead><tr>';
        $viewall = "SELECT * FROM `users`";
        $result = mysqli_query($db, $viewall);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck>0){

            $out .="<th>Username</th><th>First Name</th><th>Last Name</th><th>Student's Number</th><th>Parent's Number</th><th>School</th><th>Gender</th></tr></thead><tbody>";

            while ($row = mysqli_fetch_assoc($result)){

                $out .="<tr><td>".$row['Username']."</td>";
                $out .="<td>".$row['first name']."</td>";
                $out .="<td>".$row['last name']."</td>";
                $out .="<td>".$row['phone no']."</td>";
                $out .="<td>".$row['parentphone']."</td>";
                $out .="<td>".$row['school']."</td>";
                $out .="<td>".$row['gender']."</td></tr>";
            }

            $out .="</tbody></table></div>";
            echo $out;
        } else { echo "Empty";}
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
    <script src="dropdown2.js"></script>
    </body>
</html> 