<?php
    session_start();
    error_reporting(0);
    require_once '../config/db_config.php';


    $statusMsg = '';
    $success = '';
    $fname = filter_var($_POST['firstName'],FILTER_SANITIZE_STRING);
    $lname = filter_var($_POST['lastName'],FILTER_SANITIZE_STRING);
    $college =filter_var($_POST['college'],FILTER_SANITIZE_STRING);
    $sutdID =filter_var($_POST['studID'],FILTER_SANITIZE_STRING);
    $pass = filter_var($_POST['pass'],FILTER_SANITIZE_STRING);
    $campus = filter_var($_POST['campus'],FILTER_SANITIZE_STRING);
    $year = filter_var($_POST['year'],FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'],FILTER_SANITIZE_STRING);
    $program = filter_var($_POST['program'],FILTER_SANITIZE_STRING);



    //logs
    $tempCampus = $_SESSION['username'];
    $action = "Added voter | ".$fname." ".$lname;

    $query2 = "INSERT INTO tblogs(name,action,timestamp) VALUES('$tempCampus', '$action',Now())";

    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    if(isset($_POST['submit']))

    $query = "INSERT into tbssgvoters (fname,lname,campus, college,program,year,stud_id,password,email) VALUES('$fname','$lname','$campus','$college','$program','$year','$sutdID','$pass','$email')";

    if(mysqli_query($conn,$query) == TRUE){
        $success = 'true';
        mysqli_query($conn,$query2);
    }else{
        $statusMsg = "Sorry, there was an error adding voter.The entered student ID or email already exist in the database";
    }


?>