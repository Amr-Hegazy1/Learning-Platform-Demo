<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Work</title>
    <link rel="stylesheet" href="./styles/styles.css">

</head>
<body>
    <?php 
     try{
        $li = false;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION['assistant'])){$a = $_SESSION['assistant'];}
        if(isset($_SESSION['assistantloggedin'])){
            $li = $_SESSION['assistantloggedin'];}
        if($li){ 
            include_once("nav-assistant.html");
            include "configeach.php";
            ?>
            <div class="container center">
                <div class="segment single-seg">

                <h1 class="title">Select Assignment</h1>
                <div class="line"></div>

                <form method="POST" enctype="multipart/form-data">

                    <select name='id' id='id' hidden="hidden">

                        <?php
                            $getavas = $db->query("SELECT * FROM `assignments`");

                            while($rows = $getavas->fetch_assoc()){
                                $thisid = $rows['AssignmentID'];
                                $thisdesc = $rows['Description'];
                                echo "<option value='$thisdesc'>$thisdesc</option>";
                            }
                        ?>   
                    </select>

                    <div class="drop-down" id="drop-down">
                        <div class="name" id="assign-drop">Assignment Name : <span id="selected-drop"></span></div>
                        <div id="drop-button">▼</div>
                    </div>

                    <div class="options-cont wide-options" id="options">
                        <ul>
                            <?php
                                $getavas = $db->query("SELECT * FROM `assignments`");
                                while($rows = $getavas->fetch_assoc()){
                                    $thisid = $rows['AssignmentID'];
                                    $thisdesc = $rows['Description'];
                                    echo "<li class='option'>$thisdesc</li>";
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
                $assignmentdesc = $_POST['id'];
                $viewworksql = "SELECT w.* FROM work AS w INNER JOIN assignments AS a ON w.Corrected=0 AND a.Description='$assignmentdesc' ORDER BY `WorkID` ASC";
                $res = mysqli_query($db, $viewworksql);
                if(mysqli_num_rows($res)>0){
                    while ($work = mysqli_fetch_assoc($res)){
                        echo "<div class='all-assign'>";
                        echo "<div class='qa-cont assignment-correct'>";
                        $wid = $work['WorkID'];
                        $_SESSION['wid'] = $wid;
                        $user = $work['UserID'];
                        //echo "$user  :  ";
                        $late = lateCheck($work['Late']);
                        echo "$late";
                        echo '<a href="./correctingpage.php?workFile='.$work['WorkFile'].'"/> Correct </a>';
                        echo "</div>";}            
                } else {
                    echo "<div class='pop-up'>No Assignments to be corrected yet</div>";
                }
            }
        } else {
            echo "<div class='pop-up'>Access denied</div>";
            echo '<a href="index.php">Go Home</a><br>';;
        }
        function lateCheck($x){
            if($x == 0){
                return "On Time";
            }else {
                return "Late";
            }
        }
    }catch( Error $ex){
        echo $ex;
    }catch(Exception $ex){
        echo $ex;
    }
    ?>
    <script src="styles/dropdown.js"></script>
    <script src="styles/dropdown-vid.js"></script>
    <script src="styles/dropdown2.js"></script>
    <script src="styles/chooseFile.js"></script>

</body>
</html>