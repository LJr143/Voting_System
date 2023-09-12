<?php
session_start();
include '../config/db_config.php';
date_default_timezone_set('Asia/Manila');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$result = array();

$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$userType = mysqli_real_escape_string($conn, $_POST['userType']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, md5($_POST['password']));

// Capture system log data
$tempCampus = $_SESSION['username'];
$temNAme = $fname . " " . $lname;
$dt = date('Y-m-d G:i:s');
$action = " Added user | \"$temNAme\" | \"$userType\"";

$query4 = "SELECT admin_id FROM tbadmin WHERE username = '$tempCampus'";
$resultSystemLog = mysqli_query($conn, $query4);
$row = mysqli_fetch_assoc($resultSystemLog);
if ($row) {
    $admin_id = $row['admin_id'];

    // Use a flag to track the success of system log insertion
    $systemLogSuccess = false;

    // Insert system log data into a separate table
    $query2 = "INSERT INTO tb_admin_action_logs (admin_id, action, log_action_date) VALUES ('$admin_id', '$action', '$dt')";

    if (mysqli_query($conn, $query2)) {
        // System log insertion was successful
        $systemLogSuccess = true;
    }
}

// Use a flag to track the success of user data insertion
$userDataSuccess = false;

// Insert user data into the tbadmin table
$sql = "INSERT INTO tbadmin (firstName, lastName, username, password, role) VALUES ('$fname', '$lname', '$username', '$password', '$userType')";

if (mysqli_query($conn, $sql)) {
    // User data insertion was successful
    $userDataSuccess = true;
}

// Check if both system log and user data insertions were successful
if ($systemLogSuccess && $userDataSuccess) {
    $finalResult = "success";
} else {
    $finalResult = "error";
}

echo json_encode(array("result" => $finalResult));

$conn->close();
?>
