<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Platform</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="styles/nav-style.css">
</head>
<body>
<?php 
include_once("nav-index.html");
$selected = $_SESSION['selected'];
$sql = $dbc->query("SELECT * FROM `courses` WHERE `D`='$selected'");
echo "<div class='container center'>";
while($row = $sql->fetch_assoc()){
    echo "<div class='segment single-seg segment-course'>";
    echo "<h1>".$row['Title']."</h1>"."<h3>".$row['Instructor']."</h3>";
    echo "<div class='course-desc'>";
    echo $row['Description1'];
    echo "</div>";
    echo "<button onclick=signin()>Sign in</button>";
    echo "</div>";
}
?>

</div>
<script>
    function signin(){
        window.location.href = 'signin.php'
    } 

</script>
</body>
</html>