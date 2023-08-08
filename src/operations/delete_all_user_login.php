<?php
    require_once '../config/db_config.php';
    date_default_timezone_set('Asia/Manila');

    $statusMsg = '';
    $success = '';

    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    $query = "TRUNCATE TABLE tbloginlogs";

    if(mysqli_query($conn,$query) == TRUE){
        $success = 'true';
    }else{
        $statusMsg = "Unable to delete all voters";
    }

?>  