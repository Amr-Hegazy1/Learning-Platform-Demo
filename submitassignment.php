<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Assignment Submission</title>
</head>
<body>
    <?php include_once("nav-user.html"); ?>
    <?php
        $li = false;
        session_start();
        if(isset($_SESSION['loggedin'])){
            $li = $_SESSION['loggedin'];}
        if($li){
            include "configusers.php";
            $getavas = $db->query("SELECT * FROM assignments"); //Get available assignments?>
            
            <div class="container center">
                    <div class="segment">
                    <h1 class="title">Post</h1>
                    <div class="line"></div>
                    <form method="POST" enctype="multipart/form-data">
                        <select name='id' id='id' hidden="hidden">
                        <?php
                            while($rows = $getavas->fetch_assoc()){
                                $thisid = $rows['AssignmentID'];
                                $thisdesc = $rows['Description'];
                                $thisdd = $rows['DueDate'];
                                echo "<option value='$thisid'>$thisid : $thisdesc : $thisdd</option>";
                            }
                        ?>   
                        </select>
                <div class="drop-down" id="drop-down">
                    <div class="name" id="assign-drop">Assignment ID : <span id="selected-drop"></span></div>
                    <div id="drop-button">▼</div>
                </div>
                <div class="options-cont" id="options">
                    <ul>
                        <?php
                        $getavas = $db->query("SELECT * FROM assignments");
                        while($rows = $getavas->fetch_assoc()){
                            $thisid = $rows['AssignmentID'];
                            $thisdesc = $rows['Description'];
                            $thisdd = $rows['DueDate'];
                                echo "<li class='option'>$thisid</li>";
                            }
                        ?>   

                    </ul>
                </div>
                <div id="exit-drop" class="close"></div>

                        <div class="name" id="submit-attachment">Attachments</div>
                        <input type="file" id="file-button"required name="work" class="file-input" hidden="hidden">
                        <label for="file-button" class="choose-file">
                            Choose File :<span id="file-text">No File Chosen</span>
                        </label>
                        <span></span>
                        <input type="submit" name="submit" value="Submit" class="submit">
                        </form>
                    </div>
            </div>
    <?php
        $username = $_SESSION['username'];
        if(isset($_POST['submit'])){
            $inputid = $_POST['id'];
            if(!alreadySubmitted($username, $inputid, $db)){
                $viewduedatesql = "SELECT DueDate FROM assignments WHERE `AssignmentID`= $inputid";
                $res = mysqli_query($db, $viewduedatesql);
                $resultCheck = mysqli_num_rows($res);
                if($resultCheck=1){
                    while ($row = mysqli_fetch_assoc($res)){
                        $duedate = $row['DueDate'];
                        echo "<br>";            
                    }
                } else {
                    echo "Error";}

                $filename = $_FILES["work"]["name"];
                $tempname = $_FILES["work"]["tmp_name"];
                $folder = "work/" . $filename;
                move_uploaded_file($tempname, $folder);
                date_default_timezone_set('Africa/Cairo');
                $submitdate = date("Y-m-d H:i:s");
                if($submitdate >= $duedate){
                    $latebit = 1;
                    echo "<div class='pop-up'>You submitted late :(</div>";
                } else {
                    $latebit = 0;
                    echo "<div class='pop-up'>You submitted on time</div>";
                }
                $insertworksql = "INSERT INTO `work`(`UserID`, `AssignmentID`, `WorkFile`, `Late`)VALUES('$username', '$inputid', '$folder', '$latebit')";
                if(!mysqli_query($db, $insertworksql)){
                    echo "<div class='pop-up'>Error :(</div>";
                } else {
                    echo "<div class='pop-up'>Submitted</div>";
                }
            }else{echo "<div class='pop-up'>You have already submitted this assisgnment</div>";}
        }
        $viewassignmentssql = "SELECT * FROM assignments";
        $res = mysqli_query($db, $viewassignmentssql);
        $resultCheck = mysqli_num_rows($res);
        if($resultCheck>0){
            echo "<h4>AssignmentID : Description : DueDate </h4>";
            while ($row = mysqli_fetch_assoc($res)){
                echo $row['AssignmentID']." : ";
                echo $row['Description']." : ";
                echo $row['DueDate'];
                echo "<br>";            
            }
        } else {
            echo "<div class='pop-up'>No assignments yet</div>";
        } 
    }else{
        echo "Access Denied";
    }
    function alreadySubmitted($u, $aid, $db){
        $checksql = "SELECT * FROM `work` WHERE `UserID` = '$u' AND `AssignmentID` = '$aid'";
        $r = mysqli_query($db, $checksql);
        $n = mysqli_num_rows($r);
        if($n == 1){return true;}else{return false;}; 
    }
    ?>
    <script src="dropdown.js"></script>
    <script src="chooseFile.js"></script>
</body>
</html>