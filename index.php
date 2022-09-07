<a href="manager.php">Manager</a><br><br>
<?php 
include "configcourses.php";
$sql = $dbc->query("SELECT * FROM `courses`");
while($row = $sql->fetch_assoc()){
    $thistitle = $row['Title'];
    $thisd = $row['D'];
    $thisimg = $row['Image'];
    //echo "<img src=$thisimg><br>";
    echo "<a href='$thisd.php'>$thistitle</a><br>";
}
?>