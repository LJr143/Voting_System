<?php

    session_start();
    require_once '../../config/db_config.php';

    $currPass= md5(filter_var($_POST['currPass'],FILTER_SANITIZE_STRING));
    $newPass= md5(filter_var($_POST['newPass'],FILTER_SANITIZE_STRING));
    $tempPass = '';
    $tempUser = $_SESSION['username'];

    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    $update_result = array();

    $query = "SELECT * from tbadmin where username = '$tempUser' AND campus = 'SSG' ";
    $result = mysqli_query($conn,$query);
    while($row = mysqli_fetch_assoc($result)){
        $tempPass = $row['password'];
    }


    if($tempPass == $currPass){
        $query2 = "UPDATE tbadmin set password = '$newPass' where username = '$tempUser' ";
        mysqli_query($conn,$query2);
    }else{
        $update_result[] = array("update_result" => "incorrect_pass");
    }

    echo json_encode($update_result);




?>