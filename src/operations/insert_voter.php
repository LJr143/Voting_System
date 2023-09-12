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
$pass = $_POST['pass'];
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

    // Retrieve admin_id based on tempCampus
    $queryAdminId = "SELECT admin_id FROM tbadmin WHERE username = :tempCampus";
    $stmtAdminId = $pdo->prepare($queryAdminId);
    $stmtAdminId->bindParam(':tempCampus', $tempCampus, PDO::PARAM_STR);
    $stmtAdminId->execute();
    $rowAdminId = $stmtAdminId->fetch(PDO::FETCH_ASSOC);
    $admin_id = ($rowAdminId) ? $rowAdminId['admin_id'] : null;

    // Prepare the INSERT query for adding a voter
    $stmtInsert = $pdo->prepare('INSERT INTO tb_voter (fname, lname, program_id, college_id, campus, year, stud_id, password, email) VALUES (:fname, :lname, :programId, :collegeId, :campus, :year, :studId, :password, :email)');

    // Bind the parameter values for adding a voter
    $stmtInsert->bindParam(':fname', $fname, PDO::PARAM_STR);
    $stmtInsert->bindParam(':lname', $lname, PDO::PARAM_STR);
    $stmtInsert->bindParam(':programId', $programId, PDO::PARAM_INT);
    $stmtInsert->bindParam(':collegeId', $collegeId, PDO::PARAM_INT);
    $stmtInsert->bindParam(':campus', $campus, PDO::PARAM_STR);
    $stmtInsert->bindParam(':year', $year, PDO::PARAM_STR);
    $stmtInsert->bindParam(':studId', $studID, PDO::PARAM_STR);
    $stmtInsert->bindParam(':password', $pass, PDO::PARAM_STR);
    $stmtInsert->bindParam(':email', $email, PDO::PARAM_STR);

    // Execute the INSERT query for adding a voter
    $stmtInsert->execute();

    // Check if the voter insertion was successful
    if ($stmtInsert) {
        $success = 'true';

        // Insert system log data into the tb_admin_action_logs table
        $query2 = "INSERT INTO tb_admin_action_logs (admin_id, action, log_action_date) VALUES (:admin_id, :action, :dt)";
        $stmtLog = $pdo->prepare($query2);
        $stmtLog->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $stmtLog->bindParam(':action', $action, PDO::PARAM_STR);
        $stmtLog->bindParam(':dt', $dt, PDO::PARAM_STR);
        $stmtLog->execute();
    } else {
        $statusMsg = "Sorry, there was an error adding the voter. The entered student ID or email already exists in the database";
    }
} catch (PDOException $e) {
    // Handle any PDO exceptions here
    $statusMsg = "PDO Error: " . $e->getMessage();
}
?>
