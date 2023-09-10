<?php

session_start();
require_once '../../config/db_config.php';
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);


$college = $_POST['college']; 
$campus = $_SESSION['campus'];

$sql = "SELECT * FROM vw_program WHERE college_name = '$college' ";

$result = mysqli_query($conn,$sql);

$users_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $userid = $row['id'];
    $name = $row['college_program_name'];

    $users_arr[] = array("id" => $userid, "program" => $name);
}

// encoding array to json format
echo json_encode($users_arr);

?>