<?php
    session_start();
    error_reporting(0);
    date_default_timezone_set('Asia/Manila');
    require_once '../config/db_config.php';
    require_once("../excel_script/db-class.php");
    require_once("../excel_script/xlsxwriter.class.php");

    ini_set("display_errors", 1);
    ini_set("log_errors", 1);
    error_reporting(E_ALL & ~E_NOTICE); 

    if(!isset($_SESSION['username'])){
      header("location: ../index_admin.php");
    }

    if(isset($_POST['export'])){
        function getData() {
        $campus_name = $_SESSION['campus'];
        $db = new MY_SQLDB();
        $sql = "SELECT fname,lname,campus,college,year,stud_id,password,email from tbssgvoters ";
        $rows = $db->get_rows($sql);
        $sheet_titles = $db->get_column_names();
        $data = array_merge(array(), $rows);
        array_unshift($data , $sheet_titles);
        $db->close_connection();
        return $data;
    }
    
        $data = getData();
        $filename = "voters_data"."_".date("Y-m-d").".xlsx";

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
    include '../includes/ssg/add_voter_ssg.php';

    include '../operations/insert_ssg_voter.php';


?>
<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>USeP E-Voting | Manage Voters</title>

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
    <link rel="stylesheet" href="../css/add_voter.css">
    <link rel="stylesheet" href="../css/toastr.css">
    <link rel="stylesheet" href="../css/time.css">
    
  </head>
  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark static-top">
    <img id="logo" width="2.5%" src="../img/usep_logo.png" alt="">

      <a id="title" class="navbar-brand mr-1" href="../ssg/home.php">USeP E-Voting</a>

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
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#electionDateModal"><i class="fa fa-calendar" aria-hidden="true"></i>
            Election Date</a>
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

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
      <li class="text-center">
          <?php echo '<img width="50%" src="../img/campus_admin_logo/'.$_SESSION['campus'].'.png'.'"/>' ?><br><br>          
          <span class="text-white "><?php if(isset($_SESSION['loggedName'])) echo ($_SESSION['loggedName']) ?></span> <span class="text-success font-weight-bold">● Online</span>
          </li><br>
        <li class="nav-item">
          <a class="nav-link" href="../ssg/home.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../ssg/manage_candidate.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Manage Candidates</span></a>
        </li>
        <li class="nav-item active bg-danger">
          <a class="nav-link" href="../ssg/manage_voter.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Manage Voters</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../ssg/manage_election.php">
            <i class="fas fa-fw fa-sitemap"></i>
            <span>Manage Election</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../ssg/view_nominees.php">
          <i class="fas fa-eye"></i>
            <span>View Candidates</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../ssg/election_result.php">
            <i class="fas fa-fw fa-list-alt"></i>
            <span>Election Result</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../ssg/system_logs.php">
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
              <a href="#">Voters</a>
            </li>
            <li class="breadcrumb-item active">Manage Voters</li>
          </ol>

          <div class="card-body bg-dark"><span class="text-warning font-weight-bold">Note:</span> <span class="text-white">Please fill in all fields. All fields are required.</span></div>

        <!-- form for adding new nominees -->
        <div>
        <div class="row">
        <div class="col-sm">
        <div class="container">
        <div class="card card-register mx-auto mt-5 shadow p-3 mb-5 bg-white rounded">
        <div style="background:#CC6464; color:white" class="card-header"><i class="fas fa-address-book"></i> Add Voter</div>
        <div class="card-body">
          <form  id="myForm" method="post" enctype="multipart/form-data">
              <!-- first name and last name fields -->
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input <?php if(isset($_POST['firstName'])) echo $_POST['firstName'] ?>type="text" name="firstName" id="firstName" class="form-control" placeholder="First name" autofocus="autofocus">
                    <label for="firstName">First name</label>
                    <span id = "errorFirstName"style ="color:red;"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input <?php if(isset($_POST['lastName'])) echo $_POST['lastName'] ?>type="text" name="lastName" id="lastName" class="form-control" placeholder="Last name">
                    <label for="lastName">Last name</label>
                    <span id = "errorLastName"style ="color:red;"></span>
                  </div>
                </div>
              </div>
            </div> <!-- end of first name and last name fields -->

                <!-- campus select -->
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
             <select id="campus" name="campus" class="custom-select" id="inputGroupSelect04">
                <option selected>Choose Campus...</option>
                <option value="Obrero">Obrero</option>
                <option value="Mintal">Mintal</option>
                <option value="Mabini">Mabini</option>
                <option value="Tagum">Tagum</option>
             </select>
             <span id = "errorYearLevel"style ="color:red;"></span>
            </div>
            </div>
            </div> <!-- end of campus select -->

            <!-- college select -->
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
             <select id="college" name="college" class="custom-select" id="inputGroupSelect04">
                <option selected value="College">Choose College...</option>
             </select>
             <span id = "errorCollege"style ="color:red;"></span>
            </div>
            </div>
            </div> <!-- end of college select -->

             <!-- program select -->
             <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
             <select id="program" name="program" class="custom-select" id="inputGroupSelect04">
                <option selected>Choose Program...</option>
             </select>
             <span id = "errorProgram"style ="color:red;"></span>
            </div>
            </div>
            </div> <!-- end of program select --> 

              <!-- year select -->
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
             <select id="year" name="year" class="custom-select" id="inputGroupSelect04">
                <option selected>Choose Year Level...</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
             </select>
             <span id = "errorYearLevel"style ="color:red;"></span>
            </div>
            </div>
            </div> <!-- end of year select -->

            <!-- student Id field -->
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
            <div class="form-label-group">
                <input type="text" id="studID" name="studID" class="form-control" placeholder="Student ID">
                <label for="studID">ID</label>
                <span id = "errorID"style ="color:red;"></span>
            </div>
            </div>
            </div>
            </div> <!-- end of student id field -->

           <!-- password field -->
           <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
            <div class="form-label-group">
                <input type="text" id="pass" name="pass" class="form-control" placeholder="Password">
                <label for="pass">Password (mm-dd-yyyy)</label>
                <span id = "errorPassword"style ="color:red;"></span>
            </div>
            </div>
            </div>
            </div> <!-- end of password field -->

            <!-- email field -->
           <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
            <div class="form-label-group">
                <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                <label for="email">Email</label>
                <span id = "errorEmail"style ="color:red;"></span>
            </div>
            </div>
            </div>
            </div> <!-- end of email field -->

            <button id="add" class="btn btn-block" name="submit" type="submit" ><i class="fa fa-plus" aria-hidden="true"></i>Add Voter</button>
          </form> <!-- end of form -->
        </div>
        <span id="message"></span>
        <form method="post" id="import_excel_form" enctype="multipart/form-data">
                <table class="table">
                  <tr>
                    <td width="25%" style="align=right">Select Excel File</td>
                    <td width="50%"><input type="file" name="import_excel" /></td>
                    <td width="25%"><input type="submit" name="import" id="import" class="btn" value="Import" /></td>
                  </tr>
                </table>
            </form>
      </div>
    </div>
    </div>

    <!-- triggering pop up dialogs -->
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
    <div>
    <!-- Update Password Modal-->
    <div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Change Password</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
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
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>Cancel</button>
            <button class="btn btn-primary" id="savePass" ><i class="fa fa-floppy-o" aria-hidden="true"></i> Save Changes</button>
          </div>
        </div>
      </div>
    </div>
    </div>

    <!-- add and edit modal -->
     <!-- Edit Modal-->
     <div class="modal fade" id="editVoterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
            Edit Voter Information</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
            </button>
          </div>
          <div class="modal-body">
          <form  id="myForm2" method="post" enctype="multipart/form-data">
              <!-- first name and last name fields -->
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" name="newfirstName" id="newfirstName" class="form-control" placeholder="First name" autofocus="autofocus">
                    <label for="newfirstName">First name</label>
                    <span id = "newerrorFirstName"style ="color:red;"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" name="newlastName" id="newlastName" class="form-control" placeholder="Last name">
                    <label for="newlastName">Last name</label>
                    <span id = "newerrorLastName"style ="color:red;"></span>
                  </div>
                </div>
              </div>
            </div> <!-- end of first name and last name fields -->

            <!-- campus select -->
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
             <select id="newCampus" name="newCampus" class="custom-select" id="inputGroupSelect04">
                <option selected>Choose Campus...</option>
                <option value="Obrero">Obrero</option>
                <option value="Mintal">Mintal</option>
                <option value="Mabini">Mabini</option>
                <option value="Tagum">Tagum</option>
             </select>
             <span id = "errorYearLevel"style ="color:red;"></span>
            </div>
            </div>
            </div> <!-- end of campus select -->

            <!-- college select -->
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
             <select id="newCollege" name="newCollege" class="custom-select" id="inputGroupSelect04">
              <option selected value="New College">Choose College...</option>
             </select>
             <span id = "newerrorCollege"style ="color:red;"></span>
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
              <option selected value="year">Choose Year Level...</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
             </select>
             <span id = "newerrorYearLevel"style ="color:red;"></span>
            </div>
            </div>
            </div> <!-- end of year select -->

            <!-- student Id field -->
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
            <div class="form-label-group">
              <input type="text" id="newstudID" name="newstudID" class="form-control" placeholder="Student ID">
              <label for="newstudID">ID</label>
              <span id = "newerrorID"style ="color:red;"></span>
            </div>
            </div>
            </div>
            </div> <!-- end of student id field -->

            <!-- password field -->
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
            <div class="form-label-group">
                <input type="text" id="newPass3" name="newPass3" class="form-control" placeholder="Password">
                <label for="newPass3">Password (mm-dd-yyyy)</label>
                <span id = "errorNewPassword"style ="color:red;"></span>
            </div>
            </div>
            </div>
            </div> <!-- end of password field -->

             <!-- email field -->
           <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
            <div class="form-label-group">
                <input type="email" id="newEmail" name="newEmail" class="form-control" placeholder="Email">
                <label for="newEmail">Email</label>
                <span id = "newerrorEmail"style ="color:red;"></span>
            </div>
            </div>
            </div>
            </div> <!-- end of email field -->

            <p class="text-center text-secondary" style="font-size:10px">Click outside to dismiss</p>

          </form> <!-- end of form -->
          </div>

          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
            <button id="saveNewVoter" class="btn btn-primary text-white"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save Changes</button>
          </div>
        </div>
      </div>
    </div>
    <div>
     <!-- delete modal -->
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
           <h5 class="text-center">Are you sure you want to remove selected voter?</h5>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>Cancel</button>
            <button type="button" class="btn btn-primary" id="deleteVoter"><i class="fa fa-check" aria-hidden="true"></i> Yes</button>
        </div>
        </div>
    </div>
    </div>
    </div>

    <div>
     <!-- delete all modal -->
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
           <h5 class="text-center">Click "Yes" to delete all voters</h5>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
            <button type="button" class="btn btn-primary" id="deleteAllVoters"><i class="fa fa-check" aria-hidden="true"></i>Yes</button>
        </div>
        </div>
    </div>
    </div>
    </div>
 
    <div class="col-sm">
    <div class="card card-register mx-auto mt-5 shadow p-3 mb-5 bg-white rounded">
    <div class="breadcrumb"><form method="post"><button data-toggle="tooltip" title="Click to generate excel" class="btn btn-success float-left" name="export"><i class="fa fa-file-excel-o" aria-hidden="true"></i>
    Export Data</button></form></div>
    <div style="background:#CC6464; color:white"class="card-header"><i class="fas fa-table"></i> List of Voters</div>
    <div class="card-body">

    <div style="height: 400px; width: 100%;overflow-y: auto;">
    <table id="nominees" class="table table-bordered">
    <thead>
    <tr>
      <th>Name</th>
      <th>Campus</th>
      <th>College</th>
      <th>ID</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($nominees as $nominee) :  ?>
	<tr>
        <td><?= $nominee['fname']." ".$nominee['lname']; ?></td>
        <td><?= $nominee['campus']; ?></td>
        <td><?= $nominee['college']; ?></td>
        <td class="text-primary breadcrumb font-weight-bold"><?= $nominee['stud_id']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
    </div>
    </div>
    
      <!-- Breadcrumbs-->
      <ol class="breadcrumb bg-dark">
            <li>
              <a id="edit" data-toggle = "modal" data-toggle="tooltip" title="Click to edit a participant" data-target="#editVoterModal" class="btn btn-outline-success" href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
              Edit</a>
              <a id="delete" data-toggle = "modal" data-toggle="tooltip" title="Click to remove participant"  data-target="#deleteModal" class="btn btn-outline-danger" href="#"><i class="fa fa-trash" aria-hidden="true"></i>
            Delete</a>
            <a id="deleteAll" data-toggle = "modal" data-toggle="tooltip" title="Click to remove all participants"  data-target="#deleteAllModal" class="btn btn-outline-danger" href="#"><i class="fa fa-trash" aria-hidden="true"></i>
            Delete All</a>
            <button data-toggler="tooltip" title="Click to refresh voters list"  class="btn btn-outline-primary" onClick="window.location.reload();"><i class="fas fa-sync-alt"></i> Refresh</button>
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

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
            <p class="copyright-text">USeP E-Voting Copyright &copy; <?php echo date('Y') ?> All Rights Reserved by 
            <a href="#">beeEsAyTeA18
            </a>.
            </div>
          </div>
        </footer>
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
            <p class="text-success font-weight-bold">Success! New voter was added successfully</p>
           </div>
          </div>
          <div class="modal-footer">
            <div class="container text-center"><button type="button" class="btn btn-secondary" id="close2" data-dismiss="modal">Okay</button></div>
          </div>
        </div>
      </div>
    </div>
    </div>

    <div>
    <!-- election date modal -->
    <div class="modal fade" id="electionDateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content bg-warning text-white">
          <div class="modal-header bg-danger">
            <div style="background:#CC6464; color:white" class="card-header"><i class="fas fa-calendar"></i> Set the Election Date</div>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
            </button>
          </div>
          <div class="modal-body">  
          <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
              <label >Start Date</label>
              <input id="datepicker" width="276" />
            </div>
            </div>
            </div> <!-- end of start date-->

            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
              <label >Start Time</label>
              <input id="timepicker" width="276" />
            </div>
            </div>
            </div> <!-- end of start time-->

            
            <div class="form-row">
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
                <label >End Date</label>
                <input id="datepicker2" width="276" />
            </div>
            </div>
            </div> <!-- end of end date -->

            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
              <label >End Time</label>
              <input id="timepicker2" width="276" />
            </div>
            </div>
            </div> <!-- end of end time-->
        
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
 Cancel</button>
            <button class="btn btn-primary" href="#" id="saveElectionDate"><i class="fa fa-floppy-o" aria-hidden="true"></i>
 Save Changes</button>
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
              <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>Cancel</button>
            <a class="btn btn-primary" href="../admin/logout.php" id="logout"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
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
    <!-- <script src="../js/dynamic.js"></script> -->
    <script src="../js/nominee_table.js"></script>
    <script src="../js/validation2.js"></script>

     <!-- loading preloader -->
     <script src="../js/pace.js"></script>

     <!-- date picker cdn -->
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <!-- sweet alert dialog -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

      <!-- animate css -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"
    />
    <script src="../js/toastr.js"></script>
    <script src="../js/time.js"></script>

      <!-- chat room -->
      <div id="rt-8896a2e1910b867224e9470355f977b6" data-floating="true" data-side="right" data-width="700" data-height="500" data-counter="14,23"></div> <script src="https://rumbletalk.com/client/?HYtucjo~"></script>    <!-- script bar chart -->

<script>
$(document).ready(function(){
  $('#import_excel_form').on('submit', function(event){
    event.preventDefault();
    $.ajax({
      url:"../operations/ssg/upload_excel_ssg.php",
      method:"POST",
      data:new FormData(this),
      contentType:false,
      cache:false,
      processData:false,
      beforeSend:function(){
        $('#import').attr('disabled', 'disabled');
        $('#import').val('Importing...');
      },
      success:function(data)
      {
        $('#message').html(data);
        $('#import_excel_form')[0].reset();
        $('#import').attr('disabled', false);
        $('#import').val('Import');
        location.reload();
      }
    })
  });
});
</script>

<script>
$(document).ready(function() {
    var table = $('#nominees').DataTable();

      // delete voter
      $("#deleteAllVoters").click(function (event) {
          {
            $.ajax({
            type: "POST",
            url: "../operations/ssg/delete_all_ssg_voter.php",
            data: {studID:"fake"},
            dataType:'text',
            success:function(data){
                Swal.fire({
                title: 'Success',
                text: "All voters were deleted successfully",
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
    $('#nominees tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        $("#nominees tbody tr").removeClass('row_selected');        
        $(this).addClass('row_selected');
        var data = table.row( this ).data();
        var studID = data[3];
        var name = data[0];
        $("#edit").click(function (event) {
          {
            $.ajax({
            type: "POST",
            url: "../operations/ssg/fetch_ssg_voter.php",
            data: {studID:studID},
            dataType:'json',
            success:function(response){
                var len = response.length;

                for(var i= 0; i<len; i++){
                  $("#newfirstName").val(response[i]['fname']);
                  $("#newlastName").val(response[i]['lname'])
                  $("#newYear").val(response[i]['year_level']);
                  $("#newstudID").val(response[i]['stud_id']);
                  $("#newPass3").val(response[i]['pass']);
                  $("#newEmail").val(response[i]['email']);
                  $('#newProgram').append($('<option>', {
                    value: response[i]['program'],
                    text: response[i]['program'],
                    selected: "selected"
                }));

                $('#newCampus').append($('<option>', {
                    value: response[i]['campus'],
                    text: response[i]['campus'],
                    selected: "selected"
                }));

                
                $('#newCollege').append($('<option>', {
                    value: response[i]['college'],
                    text: response[i]['college'],
                    selected: "selected"
                }));
                  
                  
                  
                  
                }
            }  
            });
            }
        });
        // delete voter
        $("#deleteVoter").click(function (event) {
          {
            $.ajax({
            type: "POST",
            url: "../operations/ssg/delete_ssg_voter.php",
            data: {studID:studID,name:name},
            dataType:'text',
            success:function(data){
                Swal.fire({
                title: 'Success',
                text: "Voter deleted successfully",
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

    } );
    $(function () {
        $("#saveNewVoter").click(function (event) {
            var newFname = $('#newfirstName').val();
            var newLname = $('#newlastName').val();
            var newCollege = $('#newCollege').val();
            var newYear = $('#newYear').val();  
            var newStudID = $('#newstudID').val();
            var newPass = $('#newPass3').val();
            var newEmail = $('#newEmail').val();
            var newProgram = $('#newProgram').val();
            var newCampus = $('#newCampus').val();
        {
            $.ajax({
            type: "POST",
            url: "../operations/ssg/update_ssg_voter.php",
            data: {newFname:newFname,newLname:newLname,newCollege:newCollege,newYear:newYear,newStudID:newStudID,newPass:newPass,newEmail:newEmail,newProgram:newProgram,newCampus:newCampus},
            dataType:'text',
            success:function(data){
                Swal.fire({
                title: 'Success',
                text: "Voter data updated successfully",
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

<!-- date pickcer -->
<script>
        $('#datepicker').datepicker({
            format: 'dd mmmm yyyy',
            uiLibrary: 'bootstrap4'
        });

        $('#datepicker2').datepicker({
            format: 'dd mmmm yyyy',
            uiLibrary: 'bootstrap4'
        });
    </script>
    <!-- time picker -->
    <script>
        $('#timepicker').timepicker({
          format:'hh:mm TT'
        });
        $('#timepicker2').timepicker({
          format:'hh:mm TT'
        });
    </script>

    <!-- setting the value of date and time picker if exist in the database -->
    <script>
     $( document ).ready(function() {
      var $datepicker = $('#datepicker').datepicker();
      var $datepicker2 = $('#datepicker2').datepicker();
      var $timepicker = $('#timepicker').timepicker();
      var $timepicker2 = $('#timepicker2').timepicker();


      $datepicker.value('<?php if(isset($sDate))echo $sDate ?>');
      $datepicker2.value('<?php if(isset($eDate))echo $eDate ?>');
      $timepicker.value('<?php if(isset($sTime))echo  $sTime ?>');
      $timepicker2.value('<?php if(isset($eTime))echo  $eTime ?>');

    }); 
     
    </script>

    <!-- save the date  -->
    <!-- add event -->
<script>
 $(document).ready(function() {
        $(function () {
        $("#saveElectionDate").click(function (event) {
            var start_date = $('#datepicker').val();
            var end_date  = $('#datepicker2').val();
            var start_time = $('#timepicker').val();
            var end_time = $('#timepicker2').val();
        {
            $.ajax({
            type: "POST",
            url: "../operations/election_date_ssg.php",
            data: {start_date:start_date,end_date:end_date,start_time:start_time,end_time:end_time},
            dataType:'text',
            success:function(data){
                Swal.fire({
                title: 'Success',
                text: "Date saved successfully",
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
});
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
            toastr.warning("Please fill in all fields")
          }else{
            $.ajax({
            type: "POST",
            url: "../operations/ssg/update_pass_ssg.php",
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
<!-- prevent form resubmission -->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<script>

$('#editVoterModal').on('hidden.bs.modal', function () {
    location.reload();
})

</script>

<script>

$(document).ready(function(){

$("#college").change(function(){
    var college = $(this).val();

    $.ajax({
        url: '../operations/ssg/get_program_ssg.php',
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
        url: '../operations/ssg/get_program_ssg.php',
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


<script>

$(document).ready(function(){

$("#campus").change(function(){
    var campus = $(this).val();


    $.ajax({
        url: '../operations/ssg/get_ssg_college.php',
        type: 'post',
        data: {campus:campus},
        dataType: 'json',
        success:function(response){

            var len = response.length;

            $("#college").empty();
            for( var i = 0; i<len; i++){
                var college = response[i]['college'];
                
                $("#college").append("<option value='"+college+"'>"+college+"</option>");

            }
        }
    });
});

});


</script>


<script>

$(document).ready(function(){

$("#newCampus").change(function(){
    var campus = $(this).val();

    $.ajax({
        url: '../operations/ssg/get_ssg_college.php',
        type: 'post',
        data: {campus:campus},
        dataType: 'json',
        success:function(response){

            var len = response.length;

            $("#newCollege").empty();
            for( var i = 0; i<len; i++){
                var newCollege = response[i]['college'];
                
                $("#newCollege").append("<option value='"+newCollege+"'>"+newCollege+"</option>");

            }
        }
    });
});

});


</script>



 </body>
</html>
