<?php
session_start();
date_default_timezone_set('Asia/Manila');
require_once '../config/db_config.php';

$statusMsg = '';
$success = '';
$position = $_POST['position'];
$id = $_POST['id'];

$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

//logs
$dt = date('Y-m-d G:i:s');
$tempCampus = $_SESSION['username'];
$action = "Removed SOM student council position "."\"".$position."\"";

$query4 = "Select admin_id from tbadmin where username = '$tempCampus'";
$result = mysqli_query($conn, $query4);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $admin_id = $row['admin_id'];
    $query2 = "INSERT INTO tb_admin_action_logs(admin_id,action,log_action_date) VALUES('$admin_id', '$action','$dt')";

    $query = "DELETE from tbsomposition where code = '$id'";

    if (mysqli_query($conn, $query) == TRUE) {
        $success = 'true';
        mysqli_query($conn, $query2);
    } else {
        $statusMsg = "Unable to delete position";
    }
}else{

}

?>