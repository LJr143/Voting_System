<?php
    session_start();
    include '../../config/db_config.php';
    include '../Decryption.php';

    $connect = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    //Ajax For Saving Using Session
    $_SESSION["ProceedLocal"] = "Proceed";
    
    $campus = mysqli_real_escape_string($connect,decryption($_POST['campus']));

    $query = 'SELECT DISTINCT position_name FROM tbposition WHERE campus = "'.$campus.'" ';
    $resultPosition = mysqli_query($connect, $query);
    $resultChecke = mysqli_num_rows($resultPosition);

    for($count = 0 ; $count <= 15 ; $count++){
        if($count < $resultChecke){
            $ID = $_POST['ID'.($count+1)];
            $_SESSION["IdLocal"][$count] = intval($ID);

            $Start = $_POST['ST'.($count+1)];
            $_SESSION["StartLocal"][$count] = intval($Start);
        }else{
            $_SESSION["IdLocal"][$count] = 0;
            $_SESSION["StartLocal"][$count] = 0;

        }
    }

    while($rowPosition = mysqli_fetch_array($resultPosition)){
        if($rowPosition["position_name"] == "Business Manager" && $campus == "Tagum"){
            $ID = $_POST['ID11'];
            $_SESSION["IdLocal"][10] = intval($ID);
                
            $Start = $_POST['ST11'];
            $_SESSION["StartLocal"][10] = intval($Start);
    
            $ID = $_POST['ID12'];
            $_SESSION["IdLocal"][11] = intval($ID);
                
            $Start = $_POST['ST12'];
            $_SESSION["StartLocal"][11] = intval($Start);
        }elseif($rowPosition["position_name"] == "Senator" && $campus == "Tagum"){
            $ID = $_POST['ID13'];
            $_SESSION["IdLocal"][12] = intval($ID);
                
            $Start = $_POST['ST13'];
            $_SESSION["StartLocal"][12] = intval($Start);

            $ID = $_POST['ID14'];
            $_SESSION["IdLocal"][13] = intval($ID);
                
            $Start = $_POST['ST14'];
            $_SESSION["StartLocal"][13] = intval($Start);

            $ID = $_POST['ID15'];
            $_SESSION["IdLocal"][14] = intval($ID);
                
            $Start = $_POST['ST15'];
            $_SESSION["StartLocal"][14] = intval($Start);
        }else{
        
        }
    }
?>