<?php
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    // Create connection
    $conn = new mysqli($servername, $username, $password,"swd");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    
    $sql = "SELECT * FROM assignmentview";
    $result = $conn->query($sql);
    //print result
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["idAssignments"]. " - Name: " . $row["assignment_name"]. " " . $row["due_date"]. "<br>";
        }
    } else {
        echo "0 results";
    }
    
?>