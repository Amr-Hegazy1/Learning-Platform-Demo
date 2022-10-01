<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Videos</title>
    <link rel="stylesheet" href="./styles/video.css">

</head>
<body>
    <?php
     try{
        $li = false;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(isset($_SESSION['loggedin'])){
            $li = $_SESSION['loggedin'];}
        if($li){
            include_once("nav-user.html");
            include ("configeach.php");

            $viewsql = $db->query("SELECT * FROM `videos` WHERE `Accessebility`= 1 ORDER BY VideoID ASC");?>
            <h3 class="heading">Videos</h3>
            <div class="vcontainer">
                <div class="main-video">
                    <div class="video">
                        <video src="./videos/<?php echo $selected ?>/orientation.mp4" controls autoplay height="500px"></video>
                        <h3 class="title">Orientation</h3>
                    </div>
                </div>
                <div class="video-list">  
                    <div class="vid active">
                        <video src="./videos/<?php echo $selected ?>/orientation.mp4" muted></video>
                        <h3 class="title">Orientation</h3>
                    </div>  
                    <?php 
                    while($row = $viewsql->fetch_assoc()){ 
                        $name = $row['VideoName'];
                        $id = $row['VideoID'];
                        $loc = $row['VideoLocation'];           
                        ?>
                        <div class="vid">
                            <?php 
                                echo '<video src="'.$loc.'" muted></video>';
                                echo '<h3 class="title">'.$id.'.'.$name.'</h3>';
                            ?>
                        </div>
                        <?php } ?>
                </div>
            </div> 
<?php 
        } else {
            echo "Access denied<br>";
            echo '<a href="index.php">Go Home</a><br>';;
        }
    }catch( Error $ex){
        echo $ex;
    }catch(Exception $ex){
        echo $ex;
    }
    ?>

    
<script>
    let listVideo = document.querySelectorAll('.video-list .vid');
    let mainVideo = document.querySelector('.main-video video');
    let title = document.querySelector('.main-video .title');

    listVideo.forEach(video =>{
        video.onclick = () =>{
            listVideo.forEach(vid => vid.classList.remove('active'));
            video.classList.add('active');
            if(video.classList.contains('active')){
                let src = video.children[0].getAttribute('src');
                mainVideo.src = src;
                let text = video.children[1].innerHTML;
                title.innerHTML = text;
            };
        };
    });
</script>
</body>
</html>