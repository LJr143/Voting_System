<?php
    include '../config/db_config.php';
    include 'Decryption.php';

    $connect = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    $dbname = DB_NAME;
    $pdo = new PDO("mysql:host=localhost;dbname=$dbname", DB_USER, DB_PASS);
    $conn = new PDO("mysql:host=localhost;dbname=$dbname", DB_USER, DB_PASS); 

    //$ip_address = strip_tags(file_get_contents('http://checkip.dyndns.com/'));
    //$final = str_replace("Current IP CheckCurrent IP Address: ","",$ip_address);
    $final = $_SERVER['REMOTE_ADDR']; 
    
    $all = 'false';

    $voter = filter_var(decryption($_POST['voter']), FILTER_SANITIZE_STRING);
    $campus = filter_var(decryption($_POST['campus']), FILTER_SANITIZE_STRING);
    $mode = $_POST['mode'];
    $all = $_POST['all'];
    
    if ($mode == 'SSG'){
        $stmt= $pdo->prepare('DELETE FROM tbssgloginlogs WHERE stud_id = :voter And campus = :campus');
        $stmt->execute(['voter' => $voter , 'campus' => $campus]);
        
        if ($all == 'true'){
            $stmt2= $pdo->prepare('DELETE FROM voter_pub_ip_ssg WHERE public_ip_address = :ip');
            $stmt2->execute(['ip' => $final]);
        }
    }elseif ($mode == 'Plebiscite'){
        $stmt= $pdo->prepare('DELETE FROM tbplebloginlogs WHERE stud_id = :voter And campus = :campus');
        $stmt->execute(['voter' => $voter , 'campus' => $campus]);
        
        if ($all == 'true'){
            $stmt2= $pdo->prepare('DELETE FROM voter_pub_ip_pleb WHERE public_ip_address = :ip');
            $stmt2->execute(['ip' => $final]);
        }
    }else{
        $stmt= $pdo->prepare('DELETE FROM tbloginlogs WHERE stud_id = :voter And campus = :campus');
        $stmt->execute(['voter' => $voter , 'campus' => $campus]);
        
        if ($all == 'true'){
            $stmt2= $pdo->prepare('DELETE FROM voter_pub_ip WHERE public_ip_address = :ip');
            $stmt2->execute(['ip' => $final]);
        }
    }
    
    session_destroy();
    setcookie("top","", time() -3600);
?>