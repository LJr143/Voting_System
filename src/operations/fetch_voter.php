<?php
session_start();
require_once '../config/db_config.php';
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

$studID = $_POST['studID'];
$campus = $_SESSION['campus'];
$query = "SELECT *, college_tbl.college_name from tb_voter 
                                   LEFT JOIN college_tbl ON college_tbl.college_id = tb_voter.college_id
                                   where tb_voter.stud_id = '$studID' AND tb_voter.campus = '$campus' ";

$result = mysqli_query($conn,$query);
$resultCheck = mysqli_num_rows($result);

$resultArr = array();

if($resultCheck > 0){
    while($row = mysqli_fetch_assoc($result)){
        $resultArr[] = array("fname" => $row['fname'], "lname" => $row['lname'],   "year_level" => $row['year'], "stud_id" => $row['stud_id'],
            "pass" => $row['password'], "id" => $row['id'],"email" => $row['email']);
        $_SESSION['voter_id'] = $row['id'];

        $_SESSION['voterFname'] = $row['fname'];
        $_SESSION['voterLname']  =$row['lname'];
    }
}

echo json_encode($resultArr);



?>
