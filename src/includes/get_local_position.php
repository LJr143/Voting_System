<?php
session_start();
include "../config/db_config.php";

$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);


$college_id = $_POST['council_id'];   // department id
$campus = $_SESSION['campus'];

$sql = "SELECT * FROM tbposition where campus = '$campus'";

$result = mysqli_query($conn,$sql);

$users_arr = array();

while( $row = mysqli_fetch_array($result) ){
    $name = $row['position_name'];

    $users_arr[] = array( "name" => $name);
}

// encoding array to json format
echo json_encode($users_arr);

?>