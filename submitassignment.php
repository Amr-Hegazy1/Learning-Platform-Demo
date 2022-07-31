<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Submission</title>
</head>
<body>
    <?php
        $li = false;
        session_start();
        if(isset($_SESSION['loggedin'])){
            $li = $_SESSION['loggedin'];}
        if($li){?>
    <form method="POST" enctype="multipart/form-data">
        Assignment ID: <input type="number" name="id"><br><br>
        Your Work: <input type="file" name="work"><br><br>
        <input type="submit" name="submit" value="Submit">
    </form>
    <?php
        include "configusers.php";
        $duedate = "2012-12-12 12:12:12";
        $username = $_SESSION['username'];
        if(isset($_POST['submit'])){
            $inputid = $_POST['id'];
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
            echo "$duedate<br>";
            date_default_timezone_set('Africa/Cairo');
            $submitdate = date("Y-m-d H:i:s");
            echo $submitdate;
            if($submitdate >= $duedate){
                $latebit = 1;
            } else {
                $latebit = 0;
            }
            echo "<br>$latebit";
            $insertworksql = "INSERT INTO `work`(`UserID`, `AssignmentID`, `WorkFile`, `Late`)VALUES('$username', '$inputid', '$folder', '$latebit')";
            if(!mysqli_query($db, $insertworksql)){
                echo "<br><h2>Error :(</h2>";
            } else {
                echo "<br><h2>Submitted</h2>";
            }
        }
        include "configusers.php";
        $viewassignmentssql = "SELECT * FROM assignments";
        $res = mysqli_query($db, $viewassignmentssql);
        $resultCheck = mysqli_num_rows($res);
        if($resultCheck>0){
            while ($row = mysqli_fetch_assoc($res)){
                echo $row['AssignmentID'];
                echo $row['Description'];
                echo $row['DueDate'];
                echo "<br>";            
            }
        } else {
            echo "Empty";
        } 
    }else{
        echo "Access Denied";
    }
    ?>
</body>
</html>