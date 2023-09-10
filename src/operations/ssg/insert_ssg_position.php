<?php
    // error_reporting(0);
    session_start();
    require_once '../../config/db_config.php';

    
    

    $statusMsg = '';
    $success = '';
    $position = filter_var($_POST['position'],FILTER_SANITIZE_STRING);
    $campus = $_SESSION['campus'];
    $code = randomCode();
   
    $dt = date('Y-m-d G:i:s');
    //logs
    $tempCampus = $_SESSION['username'];
    $action = "Added new SSG position "."\" ".$position."\" ";

    $query2 = "INSERT INTO tblogs(name,action,timestamp) VALUES('$tempCampus', '$action','$dt')";

    $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    $query = "INSERT into tbssgposition (position_name, code) VALUES('$position',  '$code')";

    if(mysqli_query($conn,$query) == TRUE){
        $success = 'true';
        mysqli_query($conn,$query2);
    }else{
        $statusMsg = "Unable to add SSG position";
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