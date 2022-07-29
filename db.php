<?php
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
//preparing table to be displayed
$table_data = "<table class='table'><thead><tr>";
if (isset($_POST['table'])){
    $table = $_POST['table'];
    //getting col names from db
    $sql = "SELECT * FROM $table";
    $cols = $conn->query("DESCRIBE $table");
    $cols = $cols->fetch_all(MYSQLI_ASSOC);

    $col_data = "";
    

    //adding col names to the table
    foreach ($cols as $col){
        $col_name  = $col['Field'];
        //check for specific col names as these need special treatment
        if($col_name != "pdf_name" && $col_name != "idUsers" && $col_name != "idSubmissions" && $col_name != "idAssignments" && $col_name != "passwords" && $col_name != "due_date"){
            $col_data .= "<div class='input-group mb-3'>
            <span class='input-group-text'>$col_name</span>
            <input type='text' class='form-control' id='$col_name' name='$col_name'>
            </div>";
        }
        else if ($col_name == "pdf_name"){
            // to be able to know the field name
            $col_data .= "<div class='mb-3'>
            <label for='formFile' class='form-label'>pdf_name</label>
            <input class='form-control' type='file' id='pdfName' name='pdfName'>
          </div>";
        }
        else if ($col_name == "due_date"){
            //provide a way to input date
            $col_data .= "<div class='input-group mb-3'>
            <span class='input-group-text'>$col_name</span>
            <input type='date' class='form-control' id='$col_name' name='$col_name'>
            </div>";
        }
        
        $table_data .= "<th scope='col'>".$col['Field']."</th>";
    }

    // filling the table
    $table_data .= "</tr></thead><tbody>";
    $result = $conn->query($sql);
    
    foreach ($result as $row){
        $table_data .= "<tr>";
        
        $i = 0;
        foreach ($row as $col){
            if ($cols[$i]['Field'] == "pdf_name"){
                //provide a way to download the pdf
                $table_data .= "<td><a href='/$col' download>".$col."</a></td>";
            }else{
                $table_data .= "<td>".$col."</td>";
            }
            $i++;
        }
        $table_data .= "</tr>";
    }
    $table_data .= "</tbody></table>";
    // add the submit button to the form
    $col_data .= "<button class='btn btn-secondary' type='button' onclick='submitForm(this)' id='$table'>Submit</button>";
    // send back these data to js to render it
    $res = array($table_data,$col_data);
    echo json_encode($res);
    
    
    

}
?>