<?php
    session_start();
    date_default_timezone_set('Asia/Manila');
    require_once '../../config/db_config.php';

    $statusMsg = '';
    $success = '';
    $studID = $_POST['studID'];
    $campus = $_SESSION['campus'];

    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    $query = "DELETE from tbssgnominees";
    $tempCampus = $_SESSION['username'];
    $dt = date('Y-m-d G:i:s');
    $action = "Removed all candidates";

    $query2 = "INSERT INTO tblogs(name,action,timestamp) VALUES('$tempCampus', '$action','$dt')";
    $query3 = "DELETE from tb_ssgvotes where campus = '$campus' "; 

    if(mysqli_query($conn,$query) == TRUE){
        $success = 'true';
        mysqli_query($conn,$query2);
        mysqli_query($conn,$query3);
    }else{
        $statusMsg = "Unable to delete all nominees";
    }

?>  