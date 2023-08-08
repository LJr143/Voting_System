<?php
    session_start();
    date_default_timezone_set('Asia/Manila');
    require_once '../config/db_config.php';

    $statusMsg = '';
    $success = '';
    $party = filter_var($_POST['newPoliticalParty'],FILTER_SANITIZE_STRING);
    $id = $_POST['id'];

    
    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
     //logs
    $tempCampus = $_SESSION['username'];
    $action = "Updated party name to "."\"".$party."\"";
    $dt = date('Y-m-d G:i:s');

    $query2 = "INSERT INTO tblogs(name,action,timestamp) VALUES('$tempCampus', '$action','$dt')";

    $query = "UPDATE tbparty set party_name = '$party' where code = '$id'";

    if(mysqli_query($conn,$query) == TRUE){
        $success = 'true';
        mysqli_query($conn,$query2);
    }else{
        $statusMsg = "Unable to edit political party";
    }

?>  