<?php
    session_start();
    date_default_timezone_set('Asia/Manila');
    require_once '../config/db_config.php';

    $statusMsg = '';
    $success = '';
    $studID = $_POST['studID'];
    $campus = $_SESSION['campus'];

    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    $query = "DELETE from tbnominees where campus = '$campus'";
    $tempCampus = $_SESSION['username'];
    $dt = date('Y-m-d G:i:s');
    $action = "Removed all candidates from "."$campus"." campus";

    $query4 = "Select admin_id from tbadmin where username = '$tempCampus'";
    $result = mysqli_query($conn, $query4);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
    $admin_id = $row['admin_id'];
        $query2 = "INSERT INTO tb_admin_action_logs(admin_id,action,log_action_date) VALUES('$admin_id', '$action','$dt')";
        $query3 = "DELETE from tb_votes where campus = '$campus'";

        if(mysqli_query($conn, $query)){
            $success = 'true';
            mysqli_query($conn,$query2);
            mysqli_query($conn,$query3);
        }else{
            $statusMsg = "Unable to delete all nominees";
        }
    } else {
    echo "Admin not found.";
    }



?>  