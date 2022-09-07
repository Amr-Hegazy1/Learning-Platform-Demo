<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistants Manager</title>
    <link rel="stylesheet" href="http://localhost/TCD/styles.css">

</head>
<body>
<?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){
            include_once("nav.html");
            include "configeach.php";
            $getavas = $db->query("SELECT * FROM assistants"); //Get available assistants
            ?>
        <div class="container">
        <div class="segment">
            <h1 class="title assistant-title">Add Assistant</h1>
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

                <div class="name">Re-Password</div>
                <div class="text-field">
                    <input type="password" required name="repassword" placeholder="Re-enter Password">
                    <span></span>
                </div>

                <input type="submit" name="addsubmit" value="Add" class="submit">
            </form>
        </div>


        <div class="segment">

            <h1 class="title assistant-title">Remove Assistant</h1>
            <div class="line"></div>

            <form method="POST" enctype="multipart/form-data">
                <select name='username2' id='id' hidden="hidden">

                <?php 
                    while($rows = $getavas->fetch_assoc()){
                        $thisusername = $rows['AssistantUsername'];
                        echo "<option value='$thisusername'>$thisusername</option>";
                    }
                ?>   

                </select>

                <div class="drop-down" id="drop-down">
                    <div class="name" id="assign-drop">Username: <span id="selected-drop"></span></div>
                    <div id="drop-button">▼</div>
                </div>

                <div class="options-cont wide-options" id="options">
                    <ul>
                        
                        <?php
                            $getavas = $db->query("SELECT * FROM assistants");
                            while($rows = $getavas->fetch_assoc()){
                                $thisusername = $rows['AssistantUsername'];
                                $n = getName($thisusername);
                                echo "<li class='option'>$thisusername</li>";
                            }
                        ?>   

                    </ul>
                </div>
                
                <div id="exit-drop" class="close"></div>

                <input type="submit" name="removesubmit" value="Remove" class="submit">

            </form>
        </div>
    </div>

<div id="lol" class="close"></div>    
<h1 class="table-title">Assistant Table</h1>
    <?php
            if(isset($_POST['addsubmit'])){
                $username = $_POST["username"];
                $pass = $_POST["password"];
                $rpass = $_POST['repassword'];
                if(notExists($username, $db, "Username", "users") && notExists($username, $db, "Username", "admins") && notExists($username, $db, "AssistantUsername", "assistants")){
                    if($pass == $rpass){
                        if(strong($pass)){
                            if(email($username)){
                                $hashedpass = password_hash($pass, PASSWORD_DEFAULT);
                                $addassistantsql = "INSERT INTO `assistants`(`AssistantUsername`,`AssistantPassword`)VALUES('$username', '$hashedpass')";
                                if(!mysqli_query($db, $addassistantsql)){
                                    echo "<div class='pop-up'>Assistant not Added</div>";
                                } else {
                                    echo "<div class='pop-up'>Assistant Added!</div>";}
                            }
                        }
                    } else {echo "<div class='pop-up'>Passwords don't match</div>";}
                } else {echo "<div class='pop-up'>This username already exists</div>";}
            }
            if(isset($_POST['removesubmit'])){
                $username2 = $_POST["username2"];
                $removeassistantsql = "DELETE FROM `assistants` WHERE(`AssistantUsername`= '$username2')";
                if(!mysqli_query($db, $removeassistantsql)){
                    echo "<div class='pop-up'>Assistant not Removed</div>";
                } else {
                    echo "<div class='pop-up'>Assistant Removed!</div>";
                }
            }
            $out = '<div class="table-cont">
                    <table class="table"><thead><tr>';
            $viewassistantssql = "SELECT * FROM assistants";
            $res = mysqli_query($db, $viewassistantssql);
            $resultCheck = mysqli_num_rows($res);
            if($resultCheck>0){
                $out .="<th>Name</th><th>No. Assignments Corrected</th><th>No. Questions Answered</th></tr></thead><tbody>";
                while ($row = mysqli_fetch_assoc($res)){
                    $out .= "<tr><td>".$row['AssistantUsername']."</td>";
                    $out .= "<td>".getNoAC($db, $row['AssistantUsername'])."</td>";
                    $out .= "<td>".getNoQA($db, $row['AssistantUsername'])."</td></tr>";
                }
                $out .="</tbody></table></div>";
                echo $out;
            } else {
                echo "<div class='pop-up'>Empty</div>";
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
                echo 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
                return false;
            }else{
                echo "<div class='pop-up'>Strong password.";
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
        
        function getName($email){
            $name = strstr($email, '@', true);
            return $name;             
        }

        function getNoAC($db, $name){
            $count = 0;
            $sql = $db->query("SELECT * FROM `work` WHERE `AssistantID` = '$name'");
            while($row = $sql->fetch_assoc()){
                $count += 1;
            }
            return $count;
        }

        function getNoQA($db, $name){
            $count = 0;
            $sql = $db->query("SELECT * FROM `questions` WHERE `Assistant` = '$name'");
            while($row = $sql->fetch_assoc()){
                $count += 1;
            }
            return $count;
        }
        ?>
        <script src="dropdown.js"></script>
</body>
</html>