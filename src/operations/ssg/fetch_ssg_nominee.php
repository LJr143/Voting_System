<?php
session_start();
require_once '../../config/db_config.php';
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
error_reporting(0);

$studID = $_POST['studID'];
$campus = $_SESSION['campus'];
$query = "SELECT * from tbssgnominees where stud_id = '$studID' ";

$result = mysqli_query($conn,$query);
$resultCheck = mysqli_num_rows($result);

$resultArr = array();

if($resultCheck > 0){
    while($row = mysqli_fetch_assoc($result)){
        $resultArr[] = array("fname" => $row['fname'], "lname" => $row['lname'], "campus" => $row['campus'],"college" => $row['college'],
            "year_level" => $row['year'], "stud_id" => $row['stud_id'],"id" => $row['id'],
             "position" => $row['position'], "program" => $row['program'], "image" => $row['image']);

        $_SESSION['nominee_id'] = $row['id'];
        $_SESSION['name'] = $row['fname']." ".$row['lname'];
    }
}

echo json_encode($resultArr);


?>