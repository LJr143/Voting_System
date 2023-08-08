<?php
    require_once '../config/db_config.php';

    $statusMsg = '';
    $success = '';
    $studID = $_POST['studID'];
    $campus = $_POST['campus'];


    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    $query = "DELETE from tbloginlogs where stud_id = '$studID' && campus = '$campus' ";

    if(mysqli_query($conn,$query) == TRUE){
        $success = 'true';
    }else{
        $statusMsg = "Unable to delete voter";
    }

?>  