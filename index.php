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
include "configcourses.php";
include_once "nav-index.html";
?>
    <header>
        <h1 class="website-title">
            Best e-learning  platform
        </h1>
        <img src="images/background.jpg" alt="Preview">
        <div class="website-desc">
            Learn today with many new features to make your life easier.
        </div>
        <button onclick="var e = document.getElementById('course-cont');window.scroll({top:e.getBoundingClientRect().top+window.pageYOffset,behaviour:'smooth',});">Our Courses</button>
    </header>
<?php 
 try{
    $sql = $dbc->query("SELECT * FROM `courses`");
    echo "<h1 class='our-courses'>Our Courses</h1>";
    echo "<hr>";
    echo "<div class='courses-cont' id='course-cont'>";
    //$i = 0;
    while($row = $sql->fetch_assoc()){
        $thistitle = $row['Title'];
        $thisd = $row['D'];
        $thisimg = $row['Image'];
        $thisprice = $row['Price'];
        $thisinst = $row['Instructor'];
        echo "<a class='course' href='$thisd.php' >";
        //echo "<img src=$thisimg><br>";
        echo "<img src='$thisimg'>";
        echo "<div class='course-title'>$thistitle</div>";
        echo '<div class="course-inst">By <span class=inst-name>'.$thisinst.'</span></div>';
        echo "<div class='course-price'>$$thisprice</div>";
        echo "</a>";
        // $i+=1;
        // if(i===2){
        //     echo "</div>"
        //     echo "<div class='course-cont'>";
        // }
    }
    echo "</div>";
}catch( Error $ex){
    echo $ex;
}catch(Exception $ex){
    echo $ex;
}
?>
</body>
</html>