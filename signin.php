<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="nav-style.css">

</head>
<body>
<div class="container" id="cont-add-admin">
        <div class="segment">
        <h1 class="title">Sign in</h1>
        <div class="line"></div>
    <form method="POST" enctype="multipart/form-data">

            <div class="name">Username</div>
            <div class="text-field">
                <input type="text" required name="username" id="desc" placeholder="Enter Username">
                <span></span>
            </div>

            <div class="name">Password</div>
            <div class="text-field">
                    <input type="password" required name="password" placeholder="Enter Password">
                    <span></span>
            </div>

        <input type="submit" name="loginsubmit" value="Submit" class="submit">
    </form>
    <?php
        session_start();
        include "configusers.php"; 
        if(isset($_POST['loginsubmit'])){
            $u = $_POST['username'];
            $p = $_POST['password'];
            $adminloginsql = $db->query("SELECT `Password` FROM `admins` WHERE `Username` = '$u' ");
            $assistantloginsql = $db->query("SELECT `AssistantPassword` FROM `assistants` WHERE `AssistantUsername` = '$u' ");
            $userloginsql = $db->query("SELECT `Password` FROM `users` WHERE `Username` = '$u' ");
            if(mysqli_num_rows($userloginsql) > 0){
                $r = $userloginsql->fetch_assoc();
                if(password_verify($p, $r['Password'])){
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $u;
                    header("Location:./userhome.php");
                    exit();
                }
            } else {
                if(mysqli_num_rows($assistantloginsql) > 0){
                    $r = $assistantloginsql->fetch_assoc();
                    if(password_verify($p, $r['AssistantPassword'])){
                        $_SESSION['assistantloggedin'] = true;
                        $_SESSION['assistant'] = $u;
                        header("Location:./assistanthome.php");
                        exit();
                    }
                } else {
                    if(mysqli_num_rows($adminloginsql) > 0){
                        $r = $adminloginsql->fetch_assoc();
                        if(password_verify($p, $r['Password'])){
                            $_SESSION['adminloggedin'] = true;
                            $_SESSION['admin'] = $u;
                            header("Location:./adminhome.php");
                            exit();

                        }
                    }}}
            
        }
    ?>
</body>
</html>