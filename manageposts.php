<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post an Assignment</title>
</head>
<body>
<?php
        $ali = false;
        session_start();
        if(isset($_SESSION['adminloggedin'])){
            $ali = $_SESSION['adminloggedin'];}
        if($ali == true){?>
    <h1>Post</h1>
    <hr>
    <form method="POST" enctype="multipart/form-data">
        Header: <input type='text' name='head' id='head'><br><br> 
        Description: <input type="text" name="description"><br><br>
        <input type="submit" name="postsubmit" value="Submit">
    </form>
    <h1>Remove</h1>
    <hr>
    <form method="POST" enctype="multipart/form-data">
        PostID: <input type='number' name='id' id='id'><br><br> 
        <input type="submit" name="removesubmit" value="Submit">
    </form>
    <h1>Posts Table</h1>
    <hr>
    <?php
        include "configusers.php";
        echo "Posts ID : Header : Description";
        if(isset($_POST['removesubmit'])){
            $id = $_POST["id"];
            $removepostsql = "DELETE FROM `posts` WHERE(`PostID`= '$id')";
            if(!mysqli_query($db, $removepostsql)){
                echo "<br><h2>Post not Removed :(</h2><br>";
            } else {
                echo "<br><h2>Post Removed!</h2><br>";}
        }
        if(isset($_POST['postsubmit'])){
            $h = $_POST['head'];
            $d = $_POST['description'];
            $postsql = "INSERT INTO posts(Header, Description)VALUES('$h', '$d')";
            if(!mysqli_query($db, $postsql)){
                echo "<br><h2>Post not Added :(</h2>";
            } else {
                echo "<br><h2>Post Added!</h2>";
            }
        }
        $viewpostssql = "SELECT * FROM posts";
        $res = mysqli_query($db, $viewpostssql);
        $resultCheck = mysqli_num_rows($res);
        if($resultCheck>0){
            while ($row = mysqli_fetch_assoc($res)){
                echo $row['PostID'];
                echo $row['Header'];
                echo $row['Description'];
                echo "<br>";            
            }
        } else {
            echo "Empty";
        }
    }else{
        echo "Access denied";
    }
        ?>
</body>
</html>