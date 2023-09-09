<?php
error_reporting(0);
    require_once '../config/db_config.php';

    $statusMsg = '';
    $success = '';
    $studID = $_POST['studID'];
    $campus = $_POST['campus'];
    $tempCampus = $_SESSION['username'];
$query5 = "Select fname, lname from tb_voter where stud_id = '$studID' and campus = '$campus'";
$result1 = mysqli_query($conn, $query5);
$row1 = mysqli_fetch_assoc($result);
if ($row1) {
    $stud_name = $row1['fname']. ",". $row1['lname'];

$action = "Removed user logs " . "$campus" . " campus | " . "$stud_name";

$query4 = "Select admin_id from tbadmin where username = '$tempCampus'";
$result = mysqli_query($conn, $query4);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $admin_id = $row['admin_id'];
    $query2 = "INSERT INTO tb_admin_action_logs(admin_id,action,log_action_date) VALUES('$admin_id', '$action','$dt')";
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $query = "DELETE from tbloginlogs where stud_id = '$studID' && campus = '$campus' ";

    if (mysqli_query($conn, $query)) {
        $success = 'true';
    } else {
        $statusMsg = "Unable to delete voter";
    }
}
}

?>  