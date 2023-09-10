<?php

session_start();
require_once '../../config/db_config.php';
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);


$campus = $_POST['campus']; 

$sql = "SELECT * FROM college_tbl where campus = '$campus' ";

$result = mysqli_query($conn,$sql);

$users_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $userid = $row['college_id'];
    $name = $row['college_name'];

    $users_arr[] = array("id" => $userid, "college" => $name);
}

// encoding array to json format
echo json_encode($users_arr);

?>