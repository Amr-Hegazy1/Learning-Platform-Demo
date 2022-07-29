<html lang="en" id="html">
    <head>
        <title>Learning Platform Demo</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    </head>
    <body>
        
        <button  class="btn" id="assignments" onclick="fetchData(this)">Assignments</button>
        <button  class="btn" id="users" onclick="fetchData(this)">Users</button>
        <button  class="btn" id="submissions" onclick="fetchData(this)">Submissions</button>
        <div id="table"></div>

        <div id="add"></div>


        

        <script lang="javascript">
            function fetchData(e){
                $.ajax({
                    url: "db.php",
                    type: "POST",
                    data: {
                        table: e.id
                    },
                    success: function(data){
                        data = JSON.parse(data);
                        
                        $("#table").html(data[0]);

                        
                        

                        $("#add").html(data[1]);
                        
                        
                    }
                });
                
            }
            function submitForm(e){
                var formData = new FormData();
                formData.append("table",e.id);
                var newData = [];
                //getting every value from the input fields and inserting them to a formdata
                if (e.id == "submissions"){
                    graded = $("#graded")[0].value;
                    pdf_name = document.getElementById("pdfName").files[0];
                    grade = $("#grade")[0].value;
                    assignment_id = $("#assignment_id")[0].value;
                    user_id = $("#user_id")[0].value;
                    newData = [graded,grade,assignment_id,user_id];
                    formData.append("newData",newData);
                    formData.append("pdfName",pdf_name);
                }else if (e.id == "users"){
                    first_name = $("#first_name")[0].value;
                    last_name = $("#last_name")[0].value;
                    gender = $("#gender")[0].value;
                    school = $("#school")[0].value;
                    email = $("#email")[0].value;
                    telephone_no = $("#telephone_no")[0].value;
                    paid = $("#paid")[0].value;
                    
                    role = $("#role")[0].value;
                    newData = [first_name,last_name,gender,school,email,telephone_no,paid,role];


                }else{
                    assignment_name = $("#assignment_name")[0].value;
                    due_date = $("#due_date")[0].value;
                    //adjust date format
                    date = new Date(due_date);
                    yr      = date.getFullYear();
                    month   = date.getMonth() < 10 ? '0' + (date.getMonth()+1) : date.getMonth()+1;
                    day     = date.getDate()  < 10 ? '0' + date.getDate()  : date.getDate();
                    due_date = yr + '-' + month + '-' + day;
                    
                    newData = [assignment_name,due_date];
                }

                formData.append("newData[]",newData);

                $.ajax({
                    url: "upload.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    
                });
                
                

            }
        </script>

    </body>
</html>