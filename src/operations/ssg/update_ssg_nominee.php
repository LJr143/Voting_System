<?php
session_start();
require_once '../../config/db_config.php';

$statusMsg = '';
$success ='';
$fname = filter_var($_POST['newFirstName'],FILTER_SANITIZE_STRING);
$lname = filter_var($_POST['newLastName'],FILTER_SANITIZE_STRING);
$campus = filter_var($_POST['newCampus'],FILTER_SANITIZE_STRING);
$college =filter_var($_POST['newCollege'],FILTER_SANITIZE_STRING);
$program = filter_var($_POST['newProgram'],FILTER_SANITIZE_STRING);
$year = filter_var($_POST['newYear'],FILTER_SANITIZE_STRING);
$position = filter_var($_POST['newPosition'],FILTER_SANITIZE_STRING);
$studID = filter_var($_POST['newStudID'],FILTER_SANITIZE_STRING);
$photo = filter_var($_POST['newPhoto'],FILTER_SANITIZE_STRING);

$nominee_id = $_SESSION['nominee_id'];

$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$tempName = $_SESSION['name'];
$tempCampus = $_SESSION['username'];
$action = "Edited candidate | \" ".$tempName." \" to"." \" ".$fname." ".$lname." \" ";
$query2 ="INSERT into tblogs (name,action,timestamp) VALUES('$tempCampus','$action', Now())";

$query = "UPDATE tbssgnominees set fname= '$fname', lname= '$lname', campus ='$campus',college = '$college', program = '$program', year = '$year',
         position = '$position', stud_id = '$studID' where id = '$nominee_id' ";

if(mysqli_query($conn, $query) == TRUE){
    $success= "Nominee data updated successfully";
    mysqli_query($conn,$query2);
}



?>


