<?php
    session_start();
    include '../../config/db_config.php';
    include '../Decryption.php';

    $connect = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    //Ajax For Saving Using Session
    $_SESSION["Proceed"] = "Proceed";
    $campus = mysqli_real_escape_string($connect,decryption($_POST['campus']));
    
    $query = 'SELECT DISTINCT position_name FROM tbcouncil WHERE campus = "'.$campus.'" ';
    $result = mysqli_query($connect, $query);
    $resultChecke = mysqli_num_rows($result);

    for($count = 0 ; $count <= 10 ;$count++ ){
        if($count < $resultChecke){
                $ID = $_POST['ID'.($count+1)];
                $_SESSION["Id"][$count] = intval($ID);

                $Start = $_POST['ST'.($count+1)];
                $_SESSION["Start"][$count] = intval($Start);
        }else{
                $_SESSION["Id"][$count] = 0;
                $_SESSION["Start"][$count] = 0;
        }
    }
?>