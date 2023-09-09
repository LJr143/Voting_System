<?php
session_start();
date_default_timezone_set('Asia/Manila');
require_once '../config/db_config.php';

$statusMsg = '';
$success ='';
$fname = filter_var($_POST['newFirstName'],FILTER_SANITIZE_STRING);
$lname = filter_var($_POST['newLastName'],FILTER_SANITIZE_STRING);
$campus = filter_var($_SESSION['campus'],FILTER_SANITIZE_STRING);
$college =filter_var($_POST['newCollege'],FILTER_SANITIZE_STRING);
$program = filter_var($_POST['newProgram'],FILTER_SANITIZE_STRING);
$year = filter_var($_POST['newYear'],FILTER_SANITIZE_STRING);
$party = filter_var($_POST['newParty'],FILTER_SANITIZE_STRING);
$position = filter_var($_POST['newPosition'],FILTER_SANITIZE_STRING);
$studID = filter_var($_POST['newStudID'],FILTER_SANITIZE_STRING);
$photo = filter_var($_POST['newPhoto'],FILTER_SANITIZE_STRING);
$indicator = filter_var($_POST['indicator'],FILTER_SANITIZE_STRING);

$nominee_id = $_SESSION['nominee_id'];

$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$tempName = $_SESSION['name'];
$tempCampus = $_SESSION['username'];
$dt = date('Y-m-d G:i:s');
$action = "Edited candidate | \" ".$tempName." \" to"." \" ".$fname." ".$lname." \" ";
$query4 = "Select admin_id from tbadmin where username = '$tempCampus'";
$result = mysqli_query($conn, $query4);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $admin_id = $row['admin_id'];

    $query2 = "INSERT INTO tb_admin_action_logs(admin_id,action,log_action_date) VALUES('$admin_id', '$action','$dt')";

    $query = "UPDATE tbnominees set fname= '$fname', lname= '$lname', campus ='$campus',college = '$college', program = '$program', year = '$year',
            party = '$party', position = '$position', stud_id = '$studID',indicator = '$indicator' where id = '$nominee_id' ";

    if (mysqli_query($conn, $query) == TRUE) {
        $success = "Nominee data updated successfully";
        mysqli_query($conn, $query2);
    } else {
    }
}else{
    echo "Admin not found.";
}



?>


