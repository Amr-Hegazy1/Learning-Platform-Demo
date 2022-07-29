<?php


if (isset($_POST['table'])){
    $newData = $_POST['newData'];
    //adjust array
    $newData = explode(',', $newData[0]);
    
    //CHANGE THE FOLLOWING VARIABLES ACCORDING TO YOUR SERVER
    $servername = "localhost";
    $username = "root";
    $password = "admin";

    // Create connection
    $conn = new mysqli($servername, $username, $password,"swd");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $table = $_POST['table'];
    if ($_POST['table'] == "submissions"){
        $file = $_FILES['pdfName'];
        $myfile = fopen($file['name'], "w");

        //save the file
        $file_path = "./" . $file['name'];
        move_uploaded_file($file['tmp_name'], $file_path);
        $file_name = $file['name'];

        //get data from POST
        $graded = $newData[0];
        $grade = $newData[1];
        $assignment_id = $newData[2];
        $user_id = $newData[3];
        
        //insert into db
        $conn->query("INSERT INTO $table (graded,pdf_name,grade,assignment_id,user_id) VALUES ($graded,'$file_name',$grade,$assignment_id,$user_id)");
        
        //close the file
        fclose($myfile);
    }else if ($table == "users"){
        //get data from POST

        $first_name = $newData[0];
        $last_name = $newData[1];
        $gender = $newData[2];
        $school = $newData[3];
        $email = $newData[4];
        $telephone_no = $newData[5];
        $paid = $newData[6];
        $role = $newData[7];
        
        //insert into db
        $conn->query("INSERT INTO users (first_name,last_name,gender,school,email,telephone_no,paid,role) VALUES ('$first_name','$last_name','$gender','$school','$email','$telephone_no',$paid,'$role')");
    }else{
        //get data from POST

        $assignment_name = $newData[0];
        $due_date = $newData[1];

        //insert into db
        $conn->query("INSERT INTO assignments (assignment_name,due_date) VALUES ('$assignment_name','$due_date')");
    }

    
    
    
    

    
}

?>