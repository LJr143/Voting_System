<?php
    // error_reporting(0);
    session_start();
    require_once '../config/db_config.php';


    $statusMsg = '';
    $success = '';
    $start_date = filter_var($_POST['start_date'],FILTER_SANITIZE_STRING);
    $end_date = filter_var($_POST['end_date'],FILTER_SANITIZE_STRING);
    $start_time = filter_var($_POST['start_time'],FILTER_SANITIZE_STRING);
    $end_time = filter_var($_POST['end_time'],FILTER_SANITIZE_STRING);

    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);


    $query= mysqli_query($conn, "SELECT * from tbelectiondate");
    $rowCheck = mysqli_num_rows($query);

    if($rowCheck > 0){
        $query = mysqli_query($conn, "UPDATE tbelectiondate set start_date = '$start_date', end_date = '$end_date',start_time = '$start_time', 
        end_time = '$end_time'");
        $_SESSION['election_end'] = $end_date;
    }else{
        $query = mysqli_query($conn, "INSERT into tbelectiondate (start_date,end_date,start_time,end_time) 
        values('$start_date','$end_date','$start_time','$end_time')");
        $_SESSION['election_end'] = $end_date;
    }

    $conn -> close();

?>