<?php
    session_start();
    require_once '../../config/db_config.php';

    $statusMsg = '';
    $success = '';
    $position = filter_var($_POST['newPosition'],FILTER_SANITIZE_STRING);
    $id = $_POST['id'];

    
    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    $dt = date('Y-m-d G:i:s');
     //logs
    $tempCampus = $_SESSION['username'];
    $action = "Updated SSG position name to "."\"".$position."\"";

    $query2 = "INSERT INTO tblogs(name,action,timestamp) VALUES('$tempCampus', '$action','$dt'";

    $query = "UPDATE tbssgposition set position_name = '$position' where code = '$id'";

    if(mysqli_query($conn,$query) == TRUE){
        $success = 'true';
        mysqli_query($conn,$query2);
    }else{
        $statusMsg = "Unable to edit ssg position";
    }

?>  