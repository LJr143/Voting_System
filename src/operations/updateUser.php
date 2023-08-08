<?php 
    session_start();
	include '../config/db_config.php';
	$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    //session variables 


    $result = array();
	$userID = mysqli_real_escape_string($conn,$_POST['userID']);
	$newFirstName = mysqli_real_escape_string($conn,$_POST['newFirstName']);
    $newLastName = mysqli_real_escape_string($conn,$_POST['newLastName']);
    $newUserType = mysqli_real_escape_string($conn,$_POST['newUserType']);
    $newUsername = mysqli_real_escape_string($conn,$_POST['newUsername']);
    $newPassword = mysqli_real_escape_string($conn,md5($_POST['newPassword']));
    
    $sql = "UPDATE tbadmin set firstName = '$newFirstName' ,lastName = '$newLastName', username = '$newUsername', role = '$newUserType',password = '$newPassword' WHERE admin_id = '$userID' ";
    


    

    if(mysqli_query($conn,$sql) == TRUE){
        $result[] = array("result" => "success");

	}else{
        echo $conn -> error;
        $result[] = array("result" => "error");;
    }

    echo json_encode($result);

    $conn -> close();



?>