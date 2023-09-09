<?php
error_reporting(0);
require_once '../config/db_config.php';
date_default_timezone_set('Asia/Manila');

$statusMsg = '';
$success ='';
$fname = filter_var($_POST['firstName'],FILTER_SANITIZE_STRING);
$lname = filter_var($_POST['lastName'],FILTER_SANITIZE_STRING);
$campus = filter_var($_SESSION['campus'],FILTER_SANITIZE_STRING);
$college =filter_var($_POST['college'],FILTER_SANITIZE_STRING);
$program = filter_var($_POST['program'],FILTER_SANITIZE_STRING);
$year = filter_var($_POST['year'],FILTER_SANITIZE_STRING);
$party = filter_var($_POST['party'],FILTER_SANITIZE_STRING);
$position = filter_var($_POST['position'],FILTER_SANITIZE_STRING);
$studID = filter_var($_POST['studID'],FILTER_SANITIZE_STRING);
$photo = filter_var($_POST['photo'],FILTER_SANITIZE_STRING);
$tempCouncil = filter_var($_POST['indicator'],FILTER_SANITIZE_STRING);

$temp = rand();


$action = "Added candidate | ".$fname." ".$lname." - ".$tempCouncil." - ".$position;
$tempCampus = $_SESSION['username'];
$dt = date('Y-m-d G:i:s');

$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

$query4 = "Select admin_id from tbadmin where username = '$tempCampus'";
$result = mysqli_query($conn, $query4);
$row = mysqli_fetch_assoc($result);
if ($row) {
    $admin_id = $row['admin_id'];
    $query2 = "INSERT INTO tb_admin_action_logs(admin_id,action,log_action_date) VALUES('$admin_id', '$action','$dt')";

}else {
    echo "Admin not found.";
}

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
           $query = "INSERT into tbnominees (fname,lname,campus,college,program,year,party,position,stud_id,image,indicator) values('$fname','$lname','$campus','$college',
           '$program','$year','$party','$position','$studID','$fileName','$tempCouncil')";
            if(mysqli_query($conn,$query) == TRUE){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                $success = 'true';
                mysqli_query($conn,$query2);
            }else{
                $statusMsg = "Sorry, there was an error adding candidate.The entered student ID already exists in the database";
               
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
               $query = "INSERT into tbnominees (fname,lname,campus,college,program,year,party,position,stud_id,image,indicator) values('$fname','$lname','$campus','$college',
               '$program','$year','$party','$position','$studID','$fileName','$tempCouncil')";
                if(mysqli_query($conn,$query) == TRUE){
                    $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                    $success = 'true';
                    mysqli_query($conn,$query2);
                }else{
                    $statusMsg = "Sorry, there was an error adding candidate.The entered student ID already exists in the database";             
                } 
            }else{
                $statusMsg = "Unable to add candidate, please try again.";
            }
        }
       
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG files are allowed .';
    }
}else{
    $statusMsg = 'Please attach your image.';
}

?>