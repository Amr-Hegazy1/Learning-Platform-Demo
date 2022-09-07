<?php 
$selected = $_SESSION['selected'];
$sql = $dbc->query("SELECT * FROM `courses` WHERE `D`='$selected'");
while($row = $sql->fetch_assoc()){
    echo "<h1>".$row['Title']."</h1>"."<h3>".$row['Instructor']."</h3>";
    echo $row['Description1'];
    echo $row['Description2'];
    echo $row['Description3'];
}
?>
<a href="signin.php">Sign in</a>