<form method="POST">
    <input type="datetime-local"  value="date">
    <input type="submit" value="Submit"><br>
</form>
<?php 
 try{
echo $_POST['date'];
}catch( Error $ex){
    echo $ex;
}catch(Exception $ex){
    echo $ex;
}

?>