<?php
session_start();
date_default_timezone_set('Asia/Manila');
require_once '../config/db_config.php';
require_once("../excel_script/db-class.php");
require_once("../excel_script/xlsxwriter.class.php");
ini_set("display_errors", 1);
ini_set("log_errors", 1);
error_reporting(E_ALL & ~E_NOTICE);
include '../operations/insert_nominee.php';



error_reporting(0);
if(!isset($_SESSION['username'])){
    header("location: ../index_admin.php");
}


if(isset($_POST['export'])){
    function getData() {
        $campus_name = $_SESSION['campus'];
        $db = new MY_SQLDB();
        $sql = "SELECT fname, lname, campus, college, program, year, party, position, stud_id FROM tbnominees WHERE campus = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("s", $campus_name);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $sheet_titles = $db->get_column_names();
        array_unshift($data, $sheet_titles);

        $stmt->close();
        $db->close_connection();

        return $data;
    }


    $data = getData();
    $filename = "nominees_data"."_".date("Y-m-d").".xlsx";

    $writer = new XLSXWriter();
    $writer->writeSheet($data);
    $writer->writeToFile($filename);


    header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    readfile($filename);
    exit(0);

}
include '../includes/add_nominee_add.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>USeP E-Voting | Manage Candidates</title>

    <!-- Bootstrap core CSS-->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin.css" rel="stylesheet">
    <link rel="icon" href="../img/usep_logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">

    <!-- font awesome cdn -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet"  type='text/css'>
    <link rel="stylesheet" href="../css/add_nominee.css">
    <link rel="stylesheet" href="../css/toastr.css">
    <link rel="stylesheet" href="../css/time.css">
    <link rel="stylesheet" href="../headerStyle.css">

    <style>
    </style>
</head>
<body id="page-top">
<div class="header container-fluid d-flex justify-content-center">
    <div class="d-flex text-white">
        <p>09096763912</p>
        <p class="center-Text">tsc-comelec@usep.edu.ph</p>
        <p>tsc Comelec</p>
    </div>
</div>
<div class="main-header container-fluid">
    <div class="row header-main">
        <div class="col-md-8 px-5  text-white d-flex align-content-center align-items-center ">
            <img class="img_logo img-fluid d-none d-md-block" id="logo" src="../img/usep_logo.png" alt="">
            <p class="pt-1 d-none d-md-block">University of Southeastern Philippines Tagum - Mabini Campus <br> National Highway Apokon RD. Tagum City <br>Davao Del Norte Philippines</p>
        </div>
        <div class="col-md-4 p-0 text-white d-flex justify-content-center align-items-center text-center" style="background-color: maroon;">
            <img id="logo" class="img_logo p-1 img-fluid" src="../img/comelec_logo.png" alt="">
            <p class="h1" style="font-size: 18px;margin-right: 10px;">USeP E-Voting System Environment  <br><q class="h6 text-white-50" style="font-size: 12px;">We build Dreams without limits</q></p>
            <img class="img_logo p-1" src="../img/tsc_logo.png" alt="">
        </div>
    </div>
</div>

<nav class="navbar navbar-expand navbar-dark static-top p-0" style="background: rgb(138,53,53);
  background: linear-gradient(90deg, rgb(70,4,4) 0%, rgb(40,2,2) 50%, rgb(26,4,4) 100%);
  -webkit-box-shadow: 0 8px 6px -6px #999;
  -moz-box-shadow: 0 8px 6px -6px #999;
  box-shadow: 0 8px 6px -6px #999;">
    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-12">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-fw"></i> Account
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePassModal"><i class="fa fa-key" aria-hidden="true"></i>
                    Change Password</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"><i class="fa fa-power-off" aria-hidden="true"></i>
                    Logout</a>
            </div>
        </li>
    </ul>
</nav>
<div id="wrapper" style=" background:url('../img/usep_bkg.jpg'); background-repeat: no-repeat; background-size: cover ">
    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
        <li class="text-center">
            <?php echo '<img width="50%" src="../img/campus_admin_logo/'.$_SESSION['campus'].'.png'.'"/>' ?><br><br>
            <span class="text-white "><?php if(isset($_SESSION['loggedName'])) echo ($_SESSION['loggedName']) ?></span> <span class="text-success font-weight-bold">● Online</span>
        </li><br>
        <li class="nav-item">
            <a class="nav-link" href="../admin/home.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="../admin/manage_candidate.php">
                <i class="fas fa-fw fa-users"></i>
                <span>Manage Candidates</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../admin/manage_voter.php">
                <i class="fas fa-fw fa-users"></i>
                <span>Manage Voters</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../admin/manage_election.php">
                <i class="fas fa-fw fa-sitemap"></i>
                <span>Manage Election</span></a>
        </li>
        <li class="nav-item active bg-danger">
            <a class="nav-link" href="../admin/manage_college.php">
                <i class="fas fa-fw fa-sitemap"></i>
                <span>Manage College</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../admin/view_nominees.php">
                <i class="fas fa-eye"></i>
                <span>View Candidates</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../admin/election_result.php">
                <i class="fas fa-fw fa-list-alt"></i>
                <span>Election Result</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../admin/system_logs.php">
                <i class="fas fa-fw fa-cogs"></i>
                <span>System Logs</span></a>
        </li>
        <br>
        <div class="nav-item">
            <div class="time bg-dark">
                <span class="hms"></span>
                <span class="ampm"></span>
                <br>
                <span class="date"></span>
            </div>
        </div>
        <br><br><br>
        <li class="nav-item">
            <?php foreach($dates as $date) :  ?>
                <span class="text-danger font-weigh-bold">Date of Election: </span>
                <div class="dropdown-divider"></div>
                <div class="card-body bg-warning font-weight-bold">
                    <span>Election will start on: <br> <?= $date['start_date']." ".$date['start_time'] ?> </span>
                    <div class="dropdown-divider"></div>
                    <span>Election will end on: <br> <?= $date['end_date']." ".$date['end_time']  ?></span>
                </div>
            <?php endforeach ?>
        </li>
        <br><br><br>
        <li>
            <footer>
                <div class="card-body bg-dark text-white font-weight-bold">Logged in as <br><span class="text-success"><?php if(isset($_SESSION['username'])) echo strtolower($_SESSION['username']) ?></span></div>
            </footer>
        </li>
    </ul>

    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Colleges</a>
                </li>
                <li class="breadcrumb-item active">Manage College</li>
            </ol>

            <div class="card-body bg-dark"><span class="text-warning font-weight-bold">Note:</span> <span class="text-white">Please fill in all fields. All fields are required.</span></div>

            <!-- form for adding new nominees -->
            <div>
                <div class="row">
                    <div class="col-sm">
                        <div class="container">
                            <div class="card card-register mx-auto mt-5 shadow p-3 mb-5 bg-white rounded">
                                <div style="background:#CC6464; color:white" class="card-header"><i class="fas fa-address-book"></i> Add College</div>
                                <div class="card-body">
                                    <form  id="addNomineeForm" method="post" enctype="multipart/form-data">
                                        <!-- Campus Name field -->
                                        <div class="form-group">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="form-label-group">
                                                        <input type="text" id="CollegeName" name="studID" class="form-control" placeholder="CollegeName">
                                                        <label for="CollegeName">College Name</label>
                                                        <span id = "errorName"style ="color:red;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> <!-- end college field -->


                                        <button id="add" class="btn btn-block" name="submit" type="submit" ><i class="fa fa-plus" aria-hidden="true"></i>
                                            Add Collge</button>
                                    </form> <!-- end of form -->
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php
                    if(isset($_POST['submit']))
                        if($success == 'true'){
                            ?>
                            <script type='text/javascript'>
                                window.onload = function(){
                                    $('#success-modal').modal('show');


                                }
                            </script>
                        <?php

                        }else{
                        ?>
                            <script type='text/javascript'>
                                window.onload = function(){
                                    $('#error-modal').modal('show');
                                }
                            </script>
                            <?php
                        }
                    ?>
                    <div class="col-sm">
                        <div class="card card-register mx-auto mt-5 shadow p-3 mb-5 bg-white rounded">
                            <div class="breadcrumb"><form method="post"><button data-toggler="tooltip" title="Click to generate excel" class="btn btn-success float-left" name="export"><i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                        Export Data</button></form></div>
                            <div style="background:#CC6464; color:white" class="card-header"><i class="fas fa-table"></i> Current Candidates</div>
                            <div class="card-body">
                                <div style="height: 400px; width: 100%;overflow-y: auto;">
                                    <table id="nominees" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>College</th>
                                            <th>Program</th>
                                            <th>Party</th>
                                            <th>Position</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($nominees as $nominee) :  ?>
                                            <tr>
                                                <td class="text-primary breadcrumb font-weight-bold"><?= $nominee['stud_id']; ?></td>
                                                <td><?= $nominee['fname']." ".$nominee['lname']; ?></td>
                                                <td><?= $nominee['college']; ?></td>
                                                <td><?= $nominee['program']; ?></td>
                                                <td><?= $nominee['party']; ?></td>
                                                <td><?= $nominee['position']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <div class="container text-center">
                                                    <img src="../img/warn.gif" width="50%" alt=""></div><br><br>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h5 class="text-center">Are you sure you want to remove selected candidate?</h5>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
                                                    Cancel</button>
                                                <button type="button" class="btn btn-primary" id="deleteNominee"><i class="fa fa-check" aria-hidden="true"></i>
                                                    Yes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>

                                <div>

                                    <!-- Delete ALl Modal -->
                                    <div class="modal fade" id="deleteAllModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="container text-center">
                                                        <img src="../img/warn.gif" width="50%" alt=""></div><br><br>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 class="text-center">Click "Yes" to remove all candidates</h5>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
                                                        Cancel</button>
                                                    <button type="button" class="btn btn-primary" id="deleteAllNominee"><i class="fa fa-check" aria-hidden="true"></i>
                                                        Yes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>

                                    <!-- Update Password Modal-->
                                    <div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Change Password</h5>
                                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i>
</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="form-label-group">
                                                            <input type="password" id="currPass" class="form-control" placeholder="Current Password" required="required">
                                                            <label for="currPass">Current Password</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="form-label-group">
                                                            <input type="password" id="newPass" class="form-control" placeholder="New Password" required="required">
                                                            <label for="newPass">New Password</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
                                                        Cancel</button>
                                                    <button class="btn btn-primary" id="savePass" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success text-white">
                                                    <div class="container">
                                                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                            Edit Candidate Information</h5></div>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i>
</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container text-center"><img id="nomineeImage" class=" image--cover img-thumbnail" width="50%" src="../img/default.png" alt="card image"></div><br>
                                                    <form  id="addNomineeForm2" method="post" enctype="multipart/form-data">
                                                        <!-- first name and last name fields -->
                                                        <div class="form-group">
                                                            <div class="form-row">
                                                                <div class="col-md-6">
                                                                    <div class="form-label-group">
                                                                        <input type="text" name="newFirstName" id="newFirstName" class="form-control" placeholder="First name" autofocus="autofocus">
                                                                        <label for="newFirstName">First name</label>
                                                                        <span id = "newErrorFirstName"style ="color:red;"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-label-group">
                                                                        <input type="text" name="newLastName" id="newLastName" class="form-control" placeholder="Last name">
                                                                        <label for="newLastName">Last name</label>
                                                                        <span id = "newErrorLastName"style ="color:red;"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> <!-- end of first name and last name fields -->

                                                        <!-- college select -->
                                                        <div class="form-group">
                                                            <div class="form-row">
                                                                <div class="col-md-12">
                                                                    <select id="newCollege" name="newCollege" class="custom-select" id="inputGroupSelect04">
                                                                        <option selected value="New College">Choose College...</option>
                                                                        <?php
                                                                        // Fetch college
                                                                        $campus = $_SESSION['campus'];
                                                                        $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                                                                        $query = "SELECT * FROM college_tbl where campus = '$campus'";
                                                                        $result = mysqli_query($conn,$query);
                                                                        while($row = mysqli_fetch_assoc($result) ){
                                                                            $college =  $row['college_name'];
                                                                            // Option
                                                                            echo "<option value='".$college."' >".$college."</option>";
                                                                        }
                                                                        $conn -> close();
                                                                        ?>
                                                                    </select>
                                                                    <span id = "newErrorCollege"style ="color:red;"></span>
                                                                </div>
                                                            </div>
                                                        </div> <!-- end of college select -->

                                                        <!-- program select -->
                                                        <div class="form-group">
                                                            <div class="form-row">
                                                                <div class="col-md-12">
                                                                    <select id="newProgram" name="newProgram" class="custom-select" id="inputGroupSelect04">
                                                                        <option selected>Choose Program...</option>
                                                                    </select>
                                                                    <span id = "newErrorProgram"style ="color:red;"></span>
                                                                </div>
                                                            </div>
                                                        </div> <!-- end of program select -->

                                                        <!-- year select -->
                                                        <div class="form-group">
                                                            <div class="form-row">
                                                                <div class="col-md-12">
                                                                    <select id="newYear" name="newYear" class="custom-select" id="inputGroupSelect04">
                                                                        <option selected>Choose Year Level...</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                    </select>
                                                                    <span id = "newErrorYearLevel"style ="color:red;"></span>
                                                                </div>
                                                            </div>
                                                        </div> <!-- end of year select -->

                                                        <!-- party select -->
                                                        <div class="form-group">
                                                            <div class="form-row">
                                                                <div class="col-md-12">
                                                                    <select id="newParty" name="newParty"  class="custom-select" id="inputGroupSelect04">
                                                                        <option selected>Choose Party...</option>
                                                                        <?php
                                                                        // Fetch Department
                                                                        $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                                                                        $campus = $_SESSION['campus'];
                                                                        $sql_campus = "SELECT * FROM tbparty where campus = '$campus'";
                                                                        $campus_data = mysqli_query($conn,$sql_campus);
                                                                        while($row = mysqli_fetch_assoc($campus_data) ){
                                                                            $part1= $row['party_name'];
                                                                            $part2 = $row['party_name'];
                                                                            // Option
                                                                            echo "<option value='".$part1."' >".$part2."</option>";
                                                                        }
                                                                        $conn -> close();
                                                                        ?>
                                                                    </select>
                                                                    <span id = "newErrorParty"style ="color:red;"></span>
                                                                </div>
                                                            </div>
                                                        </div> <!-- end of party select -->


                                                        <!--new council select -->
                                                        <div class="form-group">
                                                            <div class="form-row">
                                                                <div class="col-md-12">
                                                                    <select id="newIndicator" name="newIndicator" class="custom-select" id="inputGroupSelect04">
                                                                        <option selected>Choose Council...</option>
                                                                        <?php
                                                                        // Fetch types
                                                                        $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                                                                        $campus = $_SESSION['campus'];
                                                                        $sql_campus = "SELECT * FROM tborgtype";
                                                                        $campus_data = mysqli_query($conn,$sql_campus);
                                                                        while($row = mysqli_fetch_assoc($campus_data) ){
                                                                            $type_id= $row['id'];
                                                                            $org_type = $row['type'];
                                                                            // Option
                                                                            echo "<option value='".$org_type."' >".$org_type."</option>";
                                                                        }
                                                                        $conn -> close();
                                                                        ?>
                                                                    </select>
                                                                    <span id = "newErrorCouncil"style ="color:red;"></span>
                                                                </div>
                                                            </div>
                                                        </div> <!-- end of council select -->

                                                        <!-- position select -->
                                                        <div class="form-group">
                                                            <div class="form-row">
                                                                <div class="col-md-12">
                                                                    <select id="newPosition" name="newPosition" class="custom-select" id="inputGroupSelect04">
                                                                        <option selected>Choose Position...</option>

                                                                    </select>
                                                                    <span id = "newErrorPosition"style ="color:red;"></span>
                                                                </div>
                                                            </div>
                                                        </div> <!-- end of postion select -->

                                                        <!-- student Id field -->
                                                        <div class="form-group">
                                                            <div class="form-row">
                                                                <div class="col-md-12">
                                                                    <div class="form-label-group">
                                                                        <input type="text" id="newStudID" name="newStudID" class="form-control" placeholder="Student ID">
                                                                        <label for="newStudID">ID</label>
                                                                        <span id = "newErrorID"style ="color:red;"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> <!-- end of student id field -->


                                                        <!-- indicator options -->
                                                        <div class="form-group">
                                                            <div class="form-row">
                                                                <div class="col-md-12">

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <p class="text-center text-secondary" style="font-size:10px">Click outside to dismiss</p>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
                                                        Cancel</button>
                                                    <button type="button" class="btn btn-primary" id="saveChanges"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end of edit modal -->
                                </div>

                                <!-- Breadcrumbs-->
                                <ol class="breadcrumb bg-dark">
                                    <li>
                                        <a id="edit" data-toggle = "tooltip" title="Click to edit a candidate"  class="btn btn-outline-success" href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            Edit</a>
                                        <a id="delete"  data-toggle="tooltip" title="Click to remove candidate"  class="btn btn-outline-danger" href="#"><i class="fa fa-trash" aria-hidden="true"></i>
                                            Delete</a>
                                        <a id="deleteAll" data-toggle = "modal" data-toggle="tooltip" title="Click to remove all candidates" data-target="#deleteAllModal" class="btn btn-outline-danger" href="#"><i class="fa fa-trash" aria-hidden="true"></i>
                                            Delete All</a>
                                        <button data-toggler="tooltip" title="Click to refresh candidate list"  class="btn btn-outline-primary" onClick="window.location.reload();"><i class="fas fa-sync-alt"></i> Refresh</button>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div> <!-- end of col-sm -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-wrapper -->
</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<div>
    <!-- error modal  -->
    <div class="modal animate__animated animate__bounceIn" data-backdrop="static" data-keyboard="false" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger" id="priv">
                    <div class="text-center"><h5 class="modal-title text-center text-white font-weight-bold" id="exampleModalLongTitle">Error</h5></div>
                </div>
                <div class="modal-body text-center">
                    <img src="../img/error-anim.gif" width="100%" alt="">
                    <br>
                    <div>
                        <p class="text-danger"><?php echo "Error! ".$statusMsg ?></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="container text-center font-weight-bold"><button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Okay</button></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <!-- success modal  -->
    <div class="modal animate__animated animate__bounceIn" data-backdrop="static" data-keyboard="false" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success" id="priv">
                    <div class="text-center"><h5 class="modal-title text-center text-white font-weight-bold" id="exampleModalLongTitle">Success</h5></div>
                </div>
                <div class="modal-body text-center">
                    <img src="../img/success-anim.gif" width="50%" alt="">
                    <br>
                    <div>
                        <p class="text-success font-weight-bold">Success! New candidate was added successfully</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="container text-center"><button type="button" class="btn btn-secondary" id="close2" data-dismiss="modal">Okay</button></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i>
</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
                    Cancel</button>
                <a class="btn btn-primary" href="../admin/logout.php" id="logout"><i class="fa fa-sign-out" aria-hidden="true"></i>
                    Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugin JavaScript-->
<script src="../vendor/chart.js/Chart.min.js"></script>
<script src="../vendor/datatables/jquery.dataTables.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Custom scripts for all pages-->
<script src="../js/sb-admin.min.js"></script>

<!-- add nominee scripts -->
<!-- <script src="../js/dynamic.js"></script>
<script src="../js/dynamic2.js"></script> -->
<script src="../js/nominee_table.js"></script>
<script src="../js/validation.js"></script>

<!-- date picker cdn -->
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<!-- loading preloader -->
<script src="../js/pace.js"></script>

<!-- sweet alert dialog -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<!-- animate css -->
<link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"
/>

<!-- toastr -->
<script src="../js/toastr.js"></script>

<script src="../js/title-case.js"></script>
<script src="../js/time.js"></script>


<!-- // allscripts -->
<script>
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>


<script>
    $(document).ready(function() {

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }


        var counter = 0;
        // delete event
        $("#deleteAllNominee").click(function (event) {
            {
                $.ajax({
                    type: "POST",
                    url: "../operations/delete_all_nominee.php",
                    data: {studID:"fake"},
                    dataType:'text',
                    success:function(data){
                        Swal.fire({
                            title: 'Success',
                            text: "All candidates were deleted successfully",
                            icon: 'success',
                            confirmButtonColor: '#A24D4D',
                            confirmButtonText: 'Close'
                        }).then((result) => {
                            if (result.value) {
                                location.reload();
                            }
                        })
                    }
                });
            }
        });


        $("#edit").click(function(){
            if(counter ==0){
                toastr.error("Please select a candidate to edit")
            }else{
                $("#editModal").modal("show");
            }

        });


        $("#delete").click(function(){
            if(counter ==0){
                toastr.error("Please select a candidate to remove")
            }else{
                $("#deleteModal").modal("show");
            }

        });





        var table = $('#nominees').DataTable();
        $('#nominees tbody').on('click', 'tr', function () {
            var data = table.row( this ).data();
            $("#nominees tbody tr").removeClass('row_selected');
            $(this).addClass('row_selected');
            var data = table.row( this ).data();
            var studID = data[0];
            var name = data[1];
            counter++;
            $("#edit").click(function (event) {
                {
                    $.ajax({
                        type: "POST",
                        url: "../operations/fetch_nominee.php",
                        data: {studID:studID},
                        dataType:'json',
                        success:function(response){
                            var len = response.length;
                            for(var i= 0; i<len; i++){
                                $("#newFirstName").val(response[i]['fname']);
                                $("#newLastName").val(response[i]['lname'])
                                $("#newCampus").val(response[i]['campus']).change();
                                $("#newCollege").val(response[i]['college']).change();

                                $('#newProgram').append($('<option>', {
                                    value: response[i]['program'],
                                    text: response[i]['program'],
                                    selected: "selected"
                                }));

                                $('#newIndicator').append($('<option>', {
                                    value: response[i]['indicator'],
                                    text: response[i]['indicator'].toTitleCase(),
                                    selected: "selected"
                                }));

                                $('#newPosition').append($('<option>', {
                                    value: response[i]['position'],
                                    text: response[i]['position'],
                                    selected: "selected"
                                }));

                                $("#newYear").val(response[i]['year_level']).change();
                                $("#newStudID").val(response[i]['stud_id']).change();
                                $("#newParty").val(response[i]['party']).change();
                                $('#nomineeImage').attr('src', "../uploads/" + response[i]['image']);


                            }
                        }
                    });
                }
            });

            // delete event
            $("#deleteNominee").click(function (event) {
                {
                    $.ajax({
                        type: "POST",
                        url: "../operations/delete_nominee.php",
                        data: {studID:studID,name:name},
                        dataType:'text',
                        success:function(data){
                            Swal.fire({
                                title: 'Success',
                                text: "Candidate deleted successfully",
                                icon: 'success',
                                confirmButtonColor: '#A24D4D',
                                confirmButtonText: 'Close'
                            }).then((result) => {
                                if (result.value) {
                                    location.reload();
                                }
                            })
                        }
                    });
                }
            });

        });

        $(function () {
            $("#saveChanges").click(function (event) {
                var newFirstName = $('#newFirstName').val();
                var newLastName = $('#newLastName').val();
                var newCampus = $('#newCampus').val();
                var newCollege = $('#newCollege').val();
                var newProgram = $('#newProgram').val();
                var newYear = $('#newYear').val();
                var newParty = $('#newParty').val();
                var newPosition = $('#newPosition').val();
                var newStudID = $('#newStudID').val();
                var indicator = $("#newIndicator").val();
                {
                    $.ajax({
                        type: "POST",
                        url: "../operations/update_nominee.php",
                        data: {newFirstName:newFirstName,newLastName:newLastName,newCampus:newCampus,newCollege:newCollege,newProgram:newProgram,newYear:newYear,
                            newParty:newParty,newPosition:newPosition,newStudID:newStudID, indicator:indicator},
                        dataType:'text',
                        success:function(data){
                            Swal.fire({
                                title: 'Success',
                                text: "Candidate data updated successfully",
                                icon: 'success',
                                confirmButtonColor: '#A24D4D',
                                confirmButtonText: 'Close'
                            }).then((result) => {
                                if (result.value) {
                                    location.reload();
                                }
                            })
                        }
                    });
                }
            });
        });
    } );
</script>


<!-- updating password -->
<script>
    $(document).ready(function() {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        $(function () {
            $("#savePass").click(function (event) {
                var currPass = $("#currPass").val();
                var newPass = $("#newPass").val();
                {
                    if(currPass == "" || newPass == ""){
                        toastr.warning("Please fill in all fields");
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "../operations/update_password.php",
                            data: {currPass:currPass,newPass:newPass},
                            dataType:'json',
                            success:function(response){
                                var len = response.length;

                                for(var i = 0; i<len; i++){
                                    var result = response[i]["update_result"];
                                }
                                if(result == "incorrect_pass"){

                                    toastr.error("Sorry! The password you entered was incorrect");

                                }else{
                                    Swal.fire({
                                        title: 'Success',
                                        text: "Password was changed successfully",
                                        icon: 'success',
                                        confirmButtonColor: '#A24D4D',
                                        confirmButtonText: 'Close'
                                    }).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                    })

                                }

                            }
                        });
                    }
                }
            });
        });
    });
</script>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>


<!-- get positions from db -->

<script>

    $(document).ready(function(){

        $("#indicator").change(function(){
            var council_id = $(this).val();


            if(council_id == "Student Council"){

                $.ajax({
                    url: '../includes/get_council_position.php',
                    type: 'post',
                    data: {council_id:council_id},
                    dataType: 'json',
                    success:function(response){

                        var len = response.length;

                        $("#position").empty();
                        for( var i = 0; i<len; i++){
                            var name = response[i]['name'];

                            $("#position").append("<option value='"+name+"'>"+name+"</option>");

                        }
                    }
                });

            }else if(council_id == "Local Council"){

                $.ajax({
                    url: '../includes/get_local_position.php',
                    type: 'post',
                    data: {council_id:council_id},
                    dataType: 'json',
                    success:function(response){

                        var len = response.length;

                        $("#position").empty();
                        for( var i = 0; i<len; i++){
                            var name = response[i]['name'];

                            $("#position").append("<option value='"+name+"'>"+name+"</option>");

                        }
                    }
                });

            }else{
                $("#position").empty();
                var name = "Choose Position...";

                $("#position").append("<option value='"+name+"'>"+name+"</option>");

            }

        });

    });

</script>


<!-- get positions from db -->

<script>

    $(document).ready(function(){

        $("#newIndicator").change(function(){
            var council_id = $(this).val();


            if(council_id == "Student Council"){

                $.ajax({
                    url: '../includes/get_council_position.php',
                    type: 'post',
                    data: {council_id:council_id},
                    dataType: 'json',
                    success:function(response){

                        var len = response.length;

                        $("#newPosition").empty();
                        for( var i = 0; i<len; i++){
                            var name = response[i]['name'];

                            $("#newPosition").append("<option value='"+name+"'>"+name+"</option>");

                        }
                    }
                });

            }else if(council_id == "Local Council"){

                $.ajax({
                    url: '../includes/get_local_position.php',
                    type: 'post',
                    data: {council_id:council_id},
                    dataType: 'json',
                    success:function(response){

                        var len = response.length;

                        $("#newPosition").empty();
                        for( var i = 0; i<len; i++){
                            var name = response[i]['name'];

                            $("#newPosition").append("<option value='"+name+"'>"+name+"</option>");

                        }
                    }
                });

            }else{
                $("#newPosition").empty();
                var name = "Choose Position...";

                $("#newPosition").append("<option value='"+name+"'>"+name+"</option>");

            }

        });

    });

</script>

<script>

    $('#editModal').on('hidden.bs.modal', function () {
        location.reload();
    })

</script>


<script>
    console.log(college);
    $(document).ready(function(){

        $("#college").change(function(){
            var college = $(this).val();

            $.ajax({
                url: '../operations/get_program.php',
                type: 'post',
                data: {college:college},
                dataType: 'json',
                success:function(response){

                    var len = response.length;

                    $("#program").empty();
                    for( var i = 0; i<len; i++){
                        var program = response[i]['program'];

                        $("#program").append("<option value='"+program+"'>"+program+"</option>");

                    }
                }
            });
        });

    });


</script>


<script>

    $(document).ready(function(){
        var newCollege = document.getElementById('newCollege');

        newCollege.addEventListener('change',function(){

            $("#newCollege").change(function(){
                var college = $(this).val();

                $.ajax({
                    url: '../operations/get_program.php',
                    type: 'post',
                    data: {college:college},
                    dataType: 'json',
                    success:function(response){

                        var len = response.length;

                        $("#newProgram").empty();
                        for( var i = 0; i<len; i++){
                            var program = response[i]['program'];

                            $("#newProgram").append("<option value='"+program+"'>"+program+"</option>");

                        }
                    }
                });
            });


        });




    });


</script>

</body>
</html>
