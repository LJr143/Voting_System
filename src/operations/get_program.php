<?php
session_start();
require_once '../config/db_config.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$college = $_POST['college'];
$campus = $_SESSION['campus'];

$sql = "SELECT * FROM vw_program WHERE college_name = ? AND campus = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $college, $campus);
$stmt->execute();
$result = $stmt->get_result();

$users_arr = array();

while ($row = $result->fetch_assoc()) {
    $userid = $row['id'];
    $name = $row['college_program_name'];

    $users_arr[] = array("id" => $userid, "program" => $name);
}

// encoding array to json format
echo json_encode($users_arr);
?>
