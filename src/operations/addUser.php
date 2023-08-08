<?php 
    session_start();
	include '../config/db_config.php';
	$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    //session variables 


    $result = array();

	$fname = mysqli_real_escape_string($conn,$_POST['fname']);
    $lname = mysqli_real_escape_string($conn,$_POST['lname']);
    $userType = mysqli_real_escape_string($conn,$_POST['userType']);
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = mysqli_real_escape_string($conn,md5($_POST['password']));



    $sql = "INSERT INTO tbadmin(firstName,lastName,username,password,role) VALUES ('$fname', '$lname', '$username', '$password', '$userType')";
    

    if(mysqli_query($conn,$sql) == TRUE){
        $result[] = array("result" => "success");

	}else{
        echo $conn -> error;
        $result[] = array("result" => "error");;
    }

    echo json_encode($result);

    $conn -> close();



?>