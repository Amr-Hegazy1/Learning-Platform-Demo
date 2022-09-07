<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Work</title>
    <link rel="stylesheet" href="http://localhost/TCD/styles.css">

</head>
<body>
    <?php 
        $li = false;
        session_start();
        if(isset($_SESSION['assistant'])){$a = $_SESSION['assistant'];}
        if(isset($_SESSION['assistantloggedin'])){
            $li = $_SESSION['assistantloggedin'];}
        if($li){ 
            include_once("nav-assistant.html");
            echo "<h1>View Students' Work</h1><hr>";
            include "configeach.php";
            ?>
            <div class="container">  
            <div class="segment">
                        <form method="POST" enctype="multipart/form-data">
                            <select name='id' id='id' hidden="hidden">
                                <?php 
                                    $getavas = $db->query("SELECT `AssignmentID` FROM assignments");
                                    while($row = $getavas->fetch_assoc()){
                                        $thisid = $row['AssignmentID'];
                                        echo "<option value='$thisid'> Assignment $thisid</option>";
                                    }
                                ?> 
                            </select>

                            <div class="drop-down" id="drop-down">
                                <div class="name" id="assign-drop">Assignment Id : <span id="selected-drop"></span></div>
                                <div id="drop-button">▼</div>
                            </div>

                            <div class="options-cont" id="options">
                                <ul>
                                <?php
                                    $getavas2 = $db->query("SELECT `AssignmentID` FROM assignments");
                                    while($rows = $getavas2->fetch_assoc()){
                                        $thisid = $rows['AssignmentID'];
                                        echo "<li class='option'>$thisid</li>";
                                    }
                                ?>  
                                </ul>
                            </div>

                            <div id="exit-drop" class="close"></div>

                            <input type="submit" name="submit" value="Select" class="submit">
                        </form>
                        </div>
                        </div>
            <?php
        if(isset($_POST['submit'])){
            $assignmentid = $_POST['id'];
            $viewworksql = "SELECT * FROM work WHERE `AssignmentID`= '$assignmentid' AND `Corrected`=0 ORDER BY `WorkID` ASC";
            $res = mysqli_query($db, $viewworksql);
            if(mysqli_num_rows($res)>0){
                echo "<div class='all-quest'>";
                while ($work = mysqli_fetch_assoc($res)){
                    echo "<div class='qa-cont'>";

                    $wid = $work['WorkID'];
                    $_SESSION['wid'] = $wid;
                    $user = $work['UserID'];
                    //echo $user;
                    echo "<div class='question'><span class='quest-title'>";
                    $late = lateCheck($work['Late']);
                    echo "$late  ->  </span>";
                    echo '<a href="./correctingpage.php?workFile='.$work['WorkFile'].'"/> Correct </a><br></div>';                }            
            } else {
                echo "<div class='pop-up'>No Assignments Submitted yet</div>";
            }
        }
        } else {
            echo "<div class='pop-up'>Access denied</div>";
            echo '<a href="signin.php">Go Home</a><br>';;
        }
        function lateCheck($x){
            if($x == 0){
                return "On Time";
            }else {
                return "Late";
            }
        }
    ?>
    <script src="dropdown.js"></script>
    <script src="dropdown-vid.js"></script>
    <script src="dropdown2.js"></script>
    <script src="chooseFile.js"></script>

</body>
</html>