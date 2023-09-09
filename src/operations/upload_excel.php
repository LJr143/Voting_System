<?php

//import.php
session_start();
include '../vendor/autoload.php';
require_once '../config/db_config.php';

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

if ($_FILES["import_excel"]["name"] != '') {
    $allowed_extension = array('xls', 'csv', 'xlsx');
    $file_array = explode(".", $_FILES["import_excel"]["name"]);
    $file_extension = end($file_array);

    if (in_array($file_extension, $allowed_extension)) {
        $file_name = time() . '.' . $file_extension;
        move_uploaded_file($_FILES['import_excel']['tmp_name'], $file_name);
        $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

        $spreadsheet = $reader->load($file_name);

        unlink($file_name);

        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach ($data as $row) {
            $campus = $_SESSION['campus'];

            // Get college ID based on college name
            $college_name = $row[3]; // Assuming college name is in column index 3
            $college_query = "SELECT college_id FROM college_tbl WHERE college_name = :college_name";
            $college_statement = $connect->prepare($college_query);
            $college_statement->bindParam(':college_name', $college_name);
            $college_statement->execute();
            $college_result = $college_statement->fetch(PDO::FETCH_ASSOC);
            $college_id = $college_result['college_id'];

            // Get program ID based on program name
            $program_name = $row[4]; // Assuming program name is in column index 4
            $program_query = "SELECT program_id FROM college_program WHERE college_program_name = :program_name AND college_id = '$college_id'";
            $program_statement = $connect->prepare($program_query);
            $program_statement->bindParam(':program_name', $program_name);
            $program_statement->execute();
            $program_result = $program_statement->fetch(PDO::FETCH_ASSOC);
            $program_id = $program_result['program_id'];

            $insert_data = array(
                ':studID'   => $row[6],
                ':fname'    => $row[0],
                ':lname'    => $row[1],
                ':campus' => $row[2],
                 ':year'     => $row[5],
                ':email'    => $row[8],
                ':password' => $row[7]
            );

            $query = "
                INSERT INTO tb_voter
                (stud_id, lname, fname, password, year, campus, email, college_id, program_id) 
                VALUES (:studID, :lname, :fname, :password, :year, :campus, :email, $college_id, $program_id)
            ";

            $statement = $connect->prepare($query);
            $statement->execute($insert_data);
        }
        $message = '<div class="alert alert-success">Data Imported Successfully</div>';
    } else {
        $message = '<div class="alert alert-danger">Only .xls .csv or .xlsx file allowed</div>';
    }
} else {
    $message = '<div class="alert alert-danger">Please Select File</div>';
}

echo $message;

?>
