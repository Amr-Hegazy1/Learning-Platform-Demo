<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Work</title>
</head>
<body>
            <form method="POST" enctype="multipart/form-data">
                Assignment ID: <input type="number" name="id"><br><br>
                <input type="submit" name='submit' value="submit" id='submit'>
            </form>
    <?php
        include "configusers.php";
        $li = false;
        session_start();
        $li = $_SESSION['loggedin'];
        if($li){
            if($_POST['submit']){
                $assignmentid = $_POST['id'];
                $viewworksql = "SELECT * FROM work WHERE `AssignmentID`= '$assignmentid'";
                $res = mysqli_query($db, $viewworksql);
                if(mysqli_num_rows($res)>0){
                    while ($work = mysqli_fetch_assoc($res)){
                        $user = $work['UserID'];
                        echo "$user  :  ";
                        $late = lateCheck($work['Late']);
                        echo "$late  :  ";
                        $grade = $work['Grade'];
                        echo "$grade <br>";            
                    }
                } else {
                    echo "No Assignments Submitted yet";
                }
            }
        }else{
            echo "Access Denied";
        }
        function lateCheck($x){
            if($x == 0){
                return "On Time";
            }else {
                return "Late";
            }
        }
    ?>
</body>
</html>