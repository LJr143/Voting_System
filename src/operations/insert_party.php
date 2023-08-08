<?php
    // error_reporting(0);
    session_start();
    date_default_timezone_set('Asia/Manila');
    require_once '../config/db_config.php';

    
    

    $statusMsg = '';
    $success = '';
    $party = filter_var($_POST['politicalParty'],FILTER_SANITIZE_STRING);
    $campus = $_SESSION['campus'];
    $code = randomCode();
   
    
    //logs
    $tempCampus = $_SESSION['username'];
    $action = "Added new Party "."\" ".$party."\" ";
    $dt = date('Y-m-d G:i:s');

    $query2 = "INSERT INTO tblogs(name,action,timestamp) VALUES('$tempCampus', '$action','$dt')";

    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    $query = "INSERT into tbparty (party_name, campus, code) VALUES('$party', '$campus', '$code')";

    if(mysqli_query($conn,$query) == TRUE){
        $success = 'true';
        mysqli_query($conn,$query2);
    }else{
        $statusMsg = "Unable to political party";
    }



    function randomCode() {
        $alphabet = '1234567890';
        $pass = array(); 
        $alphaLength = strlen($alphabet) - 1; 
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); 
    }

?>