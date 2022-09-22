<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admit Users</title>
    <link rel="stylesheet" href="styles/styles.css">

</head>
<body>
    <?php 
        $li = false;
        if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
        if(isset($_SESSION['assistant'])){$a = $_SESSION['assistant'];}
        if(isset($_SESSION['assistantloggedin'])){
            $li = $_SESSION['assistantloggedin'];}
        if($li){ 
            include_once("nav-assistant.html");
            include "configeach.php"; ?>

            <div class="container-manage-user">
                <div class="container" id="cont-add-admin">
                    <div class="segment single-seg add-user-seg signup-seg">

                        <h1 class="title">Admit User</h1>

                        <div class="line"></div>

                        <form method="POST" enctype="multipart/form-data">
                            <select name='username1' id='id2' hidden="hidden">

                            <?php
                                $getvr = $db->query("SELECT * FROM `users` WHERE `paid` = 0");
                                while($rows = $getvr->fetch_assoc()){
                                    $thisidr = $rows['Username'];
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
                                $getvr = $db->query("SELECT * FROM `users` WHERE `paid` = 0"); 
                                while($rows = $getvr->fetch_assoc()){
                                    $thisidr = $rows['Username'];
                                    echo "<li class='option'>$thisidr</li>";
                                }
                            ?>  
                            </ul>
                            </div>

                            <div id="exit-drop" class="close"></div>

                                
                            <input type="submit" name="admit" value="Add For Free" class="submit">
                        </form>
                </div>
            </div>

            <div class="container center">
                <div class="segment add-user-seg-bottom">

                    <h1 class="title">Remove User</h1>
                    <div class="line"></div>      

                    <form method="POST" enctype="multipart/form-data">

                        <select name='username' id='id' hidden="hidden">

                            <?php
                                $getvr = $db->query("SELECT * FROM `users` WHERE `paid` = 0");
                                while($rows = $getvr->fetch_assoc()){
                                    $thisidr = $rows['Username'];
                                    echo "<option value='$thisidr'>$thisidr</option>";
                                }
                            ?>

                        </select>

                        <div class="drop-down" id="drop-down">
                            <div class="name" id="assign-drop">Username : <span id="selected-drop"></span></div>
                            <div id="drop-button">▼</div>
                        </div>

                        <div class="options-cont wide-options" id="options">
                            <ul>
                            <?php
                                $getvr = $db->query("SELECT * FROM `users` WHERE `paid` = 0"); 
                                while($rows = $getvr->fetch_assoc()){
                                    $thisidr = $rows['Username'];
                                    echo "<li class='option'>$thisidr</li>";
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

        if(isset($_POST['admit']) && isset($_POST['username1'])){
            $user = $_POST['username1'];
            admit($db, $user);
        }

        if(isset($_POST['remove']) && isset($_POST['username'])){
            $user2 = $_POST['username'];
            remove($db, $user2);
        }

        $viewall = "SELECT * FROM `users` WHERE `paid` = 0";
        $result = mysqli_query($db, $viewall);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck>0){

            echo "<h1 class='table-title'>Pending Users</h1>";
            $out = '<div class="table-cont">
            <table class="table"><thead><tr>';

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

        } else { echo '<div class="pop-up">No users yet</div>';}

        }else{
            echo "Access denied<br>";
            echo '<a href="signin.php">Go Home</a><br>';}

        function remove($db, $username){
            $sql = $db->query("DELETE FROM `users` WHERE `Username` = '$username'");
        }

        function admit($db, $username){
            $sql = $db->query("UPDATE `users` SET `paid` = 1 WHERE `Username` = '$username'");
        }
    ?>
    <script src="styles/dropdown.js"></script>
    <script src="styles/dropdown-vid.js"></script>
    <script src="styles/dropdown2.js"></script>
</body>
</html>