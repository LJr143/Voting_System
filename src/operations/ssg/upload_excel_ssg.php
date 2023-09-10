<?php

//import.php
session_start();
include '../../vendor/autoload.php';
require_once '../../config/db_config.php';

error_reporting(0);


$db_name = DB_NAME;
$connect = new PDO("mysql:host=localhost;dbname=$db_name", DB_USER, DB_PASS);

function randomPassword() {
    $alphabet = '1234567890';
    $pass = array(); 
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 6; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); 
}

if($_FILES["import_excel"]["name"] != '')
{
 $allowed_extension = array('xls', 'csv', 'xlsx');
 $file_array = explode(".", $_FILES["import_excel"]["name"]);
 $file_extension = end($file_array);

 if(in_array($file_extension, $allowed_extension))
 {
  $file_name = time() . '.' . $file_extension;
  move_uploaded_file($_FILES['import_excel']['tmp_name'], $file_name);
  $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
  $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

  $spreadsheet = $reader->load($file_name);

  unlink($file_name);

  $data = $spreadsheet->getActiveSheet()->toArray();

  foreach($data as $row)
  {
   $insert_data = array(
    ':studID'  => $row[0],
    ':fname'  => $row[1],
    ':lname'  => $row[2],
    ':campus'  => $row[3],
    ':college' => $row[4],
    ':program' => $row[5],
    ':year' => $row[6],
    ':email' => $row[7],
    ':password' => $row[8]
    
   );

   $query = "
   INSERT INTO tbssgvoters
   (stud_id,lname,fname,campus,college,program,password,year,email) 
   VALUES (:studID, :lname, :fname, :campus, :college,:program, :password,:year,:email)
   ";

   $statement = $connect->prepare($query);
   $statement->execute($insert_data);
  }
  $message = '<div class="alert alert-success">Data Imported Successfully</div>';

 }
 else
 {
  $message = '<div class="alert alert-danger">Only .xls .csv or .xlsx file allowed</div>';
 }
}
else
{
 $message = '<div class="alert alert-danger">Please Select File</div>';
}

echo $message;

?>