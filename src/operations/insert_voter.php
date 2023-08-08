<?php
session_start();
error_reporting(0);
date_default_timezone_set('Asia/Manila');
require_once '../config/db_config.php';

$statusMsg = '';
$success = '';
$fname = filter_var($_POST['firstName'], FILTER_SANITIZE_STRING);
$lname = filter_var($_POST['lastName'], FILTER_SANITIZE_STRING);
$college = filter_var($_POST['college'], FILTER_SANITIZE_STRING);
$studID = filter_var($_POST['studID'], FILTER_SANITIZE_STRING);
$pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
$campus = filter_var($_SESSION['campus'], FILTER_SANITIZE_STRING);
$year = filter_var($_POST['year'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
$program = filter_var($_POST['program'], FILTER_SANITIZE_STRING);

//logs
$tempCampus = $_SESSION['username'];
$action = "Added voter | " . $fname . " " . $lname;
$dt = date('Y-m-d G:i:s');

try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve college_id based on college name
    $collegeName = $college; // Replace with the actual college name
    $stmtCollege = $pdo->prepare('SELECT college_id FROM college_tbl WHERE college_name = :collegeName');
    $stmtCollege->bindParam(':collegeName', $collegeName, PDO::PARAM_STR);
    $stmtCollege->execute();
    $collegeRow = $stmtCollege->fetch(PDO::FETCH_ASSOC);
    $collegeId = $collegeRow['college_id'];

    // Retrieve program_id based on program name
    $programName = $program; // Replace with the actual program name
    $stmtProgram = $pdo->prepare('SELECT program_id FROM college_program WHERE college_program_name = :programName');
    $stmtProgram->bindParam(':programName', $programName, PDO::PARAM_STR);
    $stmtProgram->execute();
    $programRow = $stmtProgram->fetch(PDO::FETCH_ASSOC);
    $programId = $programRow['program_id'];

    // Prepare the INSERT query
    $stmtInsert = $pdo->prepare('INSERT INTO tb_voter (fname, lname, program_id, college_id, campus, year, stud_id, password, email) VALUES (:fname, :lname, :programId, :collegeId, :campus, :year, :studId, :password, :email)');

    // Bind the parameter values
    $stmtInsert->bindParam(':fname', $fname, PDO::PARAM_STR);
    $stmtInsert->bindParam(':lname', $lname, PDO::PARAM_STR);
    $stmtInsert->bindParam(':programId', $programId, PDO::PARAM_INT);
    $stmtInsert->bindParam(':collegeId', $collegeId, PDO::PARAM_INT);
    $stmtInsert->bindParam(':campus', $campus, PDO::PARAM_STR);
    $stmtInsert->bindParam(':year', $year, PDO::PARAM_STR);
    $stmtInsert->bindParam(':studId', $studID, PDO::PARAM_STR);
    $stmtInsert->bindParam(':password', $pass, PDO::PARAM_STR);
    $stmtInsert->bindParam(':email', $email, PDO::PARAM_STR);

    // Execute the INSERT query
    $stmtInsert->execute();

    $query2 = "INSERT INTO tblogs(name,action,timestamp) VALUES('$tempCampus', '$action','$dt')";
    if ($stmtInsert) {
        $success = 'true';
        mysqli_query($conn, $query2);
    } else {
        $statusMsg = "Sorry, there was an error adding the voter. The entered student ID or email already exists in the database" . mysqli_error($conn);
    }
} catch (PDOException $e) {
    //echo "Connection failed: " . $e->getMessage();
}
?>
