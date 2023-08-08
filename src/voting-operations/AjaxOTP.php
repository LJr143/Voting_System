<?php
session_start();

include '../config/db_config.php';
include 'Encryption.php';
include 'Decryption.php';

$dbname = DB_NAME;
$pdo = new PDO("mysql:host=localhost;dbname=$dbname", DB_USER, DB_PASS);
$conn = new PDO("mysql:host=localhost;dbname=$dbname", DB_USER, DB_PASS);

$otp = filter_var(encrypt($_POST['otp']), FILTER_SANITIZE_STRING);
$cookie = $_COOKIE['top'];
$voter = filter_var(decryption($_COOKIE['username']), FILTER_SANITIZE_STRING);
$campus = filter_var(decryption($_COOKIE['campus']), FILTER_SANITIZE_STRING);
$mode = filter_var(decryption($_COOKIE['mode']), FILTER_SANITIZE_STRING);

//$ip_address = strip_tags(file_get_contents('http://checkip.dyndns.com/'));
//$final = str_replace("Current IP CheckCurrent IP Address: ","",$ip_address);
$final = $_SERVER['REMOTE_ADDR']; 

// Set session variables
if(isset($_COOKIE['top'])){ 
    if($cookie === $otp ){
        if($mode == 'University Student Government'){
            $_SESSION["savedSSG"] = encrypt($voter);
            $_SESSION["Usep-Comelec"] = encrypt($campus);

            $stmt= $pdo->prepare('INSERT INTO tbssgloginlogs (stud_id,campus,public_Ip) VALUES (:voter,:campus,:ip)');
            $stmt->execute(['voter' => $voter , 'campus' => $campus , 'ip' => $final]);
            
            $stmt2= $pdo->prepare('INSERT INTO voter_pub_ip_ssg (public_ip_address) VALUES (:ip)');
            $stmt2->execute(['ip' => $final]);

            unset($_SESSION["Uemail"]);
            unset($_SESSION["OTP"]);
            echo json_encode(array('success','SSG'));
        }else if ($mode == 'Plebiscite'){
            $_SESSION["savedPleb"] = encrypt($voter);
            $_SESSION["Usep-Comelec"] = encrypt($campus);

            $stmt= $pdo->prepare('INSERT INTO tbplebloginlogs (stud_id,campus,public_Ip) VALUES (:voter,:campus,:ip)');
            $stmt->execute(['voter' => $voter , 'campus' => $campus , 'ip' => $final]);
            
            $stmt2= $pdo->prepare('INSERT INTO voter_pub_ip_pleb (public_ip_address) VALUES (:ip)');
            $stmt2->execute(['ip' => $final]);

            unset($_SESSION["Uemail"]);
            unset($_SESSION["OTP"]);
            echo json_encode(array('success','SSG'));
        }else{
            $_SESSION["saved"] = encrypt($voter) ;
            $_SESSION["Usep-Comelec"] = encrypt($campus);

            $stmt= $pdo->prepare('INSERT INTO tbloginlogs (stud_id,campus,public_Ip) VALUES (:voter,:campus,:ip)');
            $stmt->execute(['voter' => $voter , 'campus' => $campus , 'ip' => $final]);
            
            $stmt2= $pdo->prepare('INSERT INTO voter_pub_ip (public_ip_address) VALUES (:ip)');
            $stmt2->execute(['ip' => $final]);

            unset($_SESSION["Uemail"]);
            unset($_SESSION["OTP"]);
            echo json_encode(array('success','Campus'));
        }
    }else{
        echo json_encode(array('failed'));
    }
} else{ 
    echo json_encode(array('No Cookie'));
} 
?>