<?php
error_reporting(0);
require_once '../config/db_config.php';
date_default_timezone_set('Asia/Manila');


$statusMsg = '';
$success ='';
$fname = filter_var($_POST['firstName'],FILTER_SANITIZE_STRING);
$lname = filter_var($_POST['lastName'],FILTER_SANITIZE_STRING);
$campus = filter_var($_POST['campus'],FILTER_SANITIZE_STRING);
$college =filter_var($_POST['college'],FILTER_SANITIZE_STRING);
$program = filter_var($_POST['program'],FILTER_SANITIZE_STRING);
$year = filter_var($_POST['year'],FILTER_SANITIZE_STRING);
$position = filter_var($_POST['position'],FILTER_SANITIZE_STRING);
$studID = filter_var($_POST['studID'],FILTER_SANITIZE_STRING);
$photo = filter_var($_POST['photo'],FILTER_SANITIZE_STRING);

$temp = rand();


$action = "Added candidate | ".$fname." ".$lname." - ".$position;
$tempCampus = $_SESSION['username'];

$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

$query2 = "INSERT into tblogs (name,action,timestamp) values('$tempCampus','$action',Now())";

// File upload path
$targetDir = "../uploads/";
$fileName = basename($_FILES["photo"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"]) && !empty($_FILES["photo"]["name"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg');
    if(in_array($fileType, $allowTypes)){

        if(!file_exists($targetFilePath)){
             // Upload file to server
        if(move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $query = "INSERT into tbssgnominees (fname,lname,campus,college,program,year,position,stud_id,image) values('$fname','$lname','$campus','$college',
            '$program','$year','$position','$studID','$fileName')";
            if(mysqli_query($conn,$query) == TRUE){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                $success = 'true';
                mysqli_query($conn,$query2);
            }else{
                $statusMsg = "Sorry, there was an error adding candidate.The entered student ID already exists in the database";
                echo $conn -> error;
               
            } 
        }else{
            $statusMsg = "Unable to add candidate, please try again.";
        }

        }else{
            // $statusMsg = "File already Exist";
            // if same file name auto rename file
            $fileName = basename($_FILES["photo"]["name"]);
            $targetFilePath = $targetDir . "_".$temp.$fileName;
            $fileName =  "_".$temp.$fileName;
            if(move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)){
                // Insert image file name into database
                $query = "INSERT into tbssgnominees (fname,lname,campus,college,program,year,position,stud_id,image) values('$fname','$lname','$campus','$college',
                '$program','$year','$position','$studID','$fileName')";
                if(mysqli_query($conn,$query) == TRUE){
                    $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                    $success = 'true';
                    mysqli_query($conn,$query2);
                }else{
                    $statusMsg = "Sorry, there was an error adding candidate.The entered student ID already exists in the database";             
                } 
            }else{
                $statusMsg = "Unable to add candidate, please try again.";
                $conn -> error;
            }
        }
       
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG files are allowed .';
    }
}else{
    $statusMsg = 'Please attach your image.';
}

?>