<?php
    include "configusers.php";
    $li = false;
    session_start();
    if(isset($_SESSION['loggedin'])){
        $li = $_SESSION['loggedin'];}
    if($li){ ?>
        <form method="POST" enctype="multipart/form-data">
            Question: <input type="text" name="question"><br><br>
            <input type="submit" name='submit' value="Submit" id='submit'>
        </form>
<?php
        if(isset($_POST['submit'])){
            $user = $_SESSION['username'];
            $question = $_POST['question'];
            $asksql = "INSERT INTO questions(`User`, `Question`)VALUES('$user', '$question')";
            if(!mysqli_query($db, $asksql)){
                echo "<br><h2>Error :(</h2>";
            } else {
                echo "<br><h2>Question Submitted</h2>";
            }
        }
    }else{
        echo "Access Denied";
    }
?>