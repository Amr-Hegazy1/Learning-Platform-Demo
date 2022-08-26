<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Assistant</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include_once("nav.html")?>
<?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){
            include "configusers.php";
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
    <hr>
        <?php
            if(isset($_POST['addsubmit'])){
                $username = $_POST["username"];
                $pass = $_POST["password"];
                $hashedpass = password_hash($pass, PASSWORD_DEFAULT);
                $addassistantsql = "INSERT INTO `assistants`(`AssistantUsername`,`AssistantPassword`)VALUES('$username', '$hashedpass')";
                if(!mysqli_query($db, $addassistantsql)){
                    echo "<div class='pop-up'>Assistant not added</div>";
                } else {
                    echo "<div class='pop-up'>Assistant added</div>";}
                
            }
            if(isset($_POST['removesubmit'])){
                $username2 = $_POST["username2"];
                $removeassistantsql = "DELETE FROM `assistants` WHERE(`AssistantUsername`= '$username2')";
                if(!mysqli_query($db, $removeassistantsql)){
                    echo "<div class='pop-up'>Assistant not removed</div>";
                } else {
                    echo "<div class='pop-up'>Assignment removed</div>";}
            }
            $out = '<div class="table-cont">
                    <table class="table"><thead><tr>';

            $viewassistantssql = "SELECT * FROM assistants";
            $res = mysqli_query($db, $viewassistantssql);
            $resultCheck = mysqli_num_rows($res);
            if($resultCheck>0){
                $out .="<th>Assistant ID</th><th>Name</th></tr></thead><tbody>";
                while ($row = mysqli_fetch_assoc($res)){
                    $out .= "<tr><td>".$row['AssistantID']."</td>";
                    $out .= "<td>".$row['AssistantUsername']."</td></tr>";
                }
                $out .="</tbody></table></div>";
                echo $out;
            } else {
                echo "<div class='pop-up'>Empty</div>";
            }
        }else{
            echo "Access denied";
        }
        ?>
        <script src="dropdown.js"></script>
</body>
</html>