<?php
    session_start();
    require_once '../config/db_config.php';
    date_default_timezone_set('Asia/Manila');


    $statusMsg = '';
    $success = '';
    $studID = $_POST['studID'];

    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    

    $query = "DELETE from tb_voter where stud_id = '$studID'";

    $tempCampus = $_SESSION['username'];
    $dt = date('Y-m-d G:i:s');
    $name = $_POST['name'];
    $action = "Removed voter | "." $name";
$query4 = "Select admin_id from tbadmin where username = '$tempCampus'";
$result = mysqli_query($conn, $query4);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $admin_id = $row['admin_id'];
    $query2 = "INSERT INTO tb_admin_action_logs(admin_id,action,log_action_date) VALUES('$admin_id', '$action','$dt')";


    if (mysqli_query($conn, $query) == TRUE) {
        $success = 'true';
        mysqli_query($conn, $query2);
    } else {
        $statusMsg = "Unable to delete voter";
    }
}

?>  