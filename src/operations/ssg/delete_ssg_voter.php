<?php
    session_start();
    require_once '../../config/db_config.php';
    date_default_timezone_set('Asia/Manila');


    $statusMsg = '';
    $success = '';
    $studID = $_POST['studID'];

    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    

    $query = "DELETE from tbssgvoters where stud_id = '$studID'";

    $tempCampus = $_SESSION['username'];
    $dt = date('Y-m-d G:i:s');
    $name = $_POST['name'];
    $action = "Removed voter | "." $name";

    $query2 = "INSERT INTO tblogs(name,action,timestamp) VALUES('$tempCampus', '$action','$dt')";

    if(mysqli_query($conn,$query) == TRUE){
        $success = 'true';
        mysqli_query($conn,$query2);
    }else{
        $statusMsg = "Unable to delete voter";
    }

?>  