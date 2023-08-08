<?php
    session_start();
    require_once '../config/db_config.php';
    include '../operations/insert_nominee.php';

    //error_reporting(0);

    if(!isset($_SESSION['username'])){
      header("location: ../index_admin.php");
    }
?>

<?php
  $campus = $_SESSION['campus'];
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "SELECT * FROM tbnominees ";
  $nominees = array();
  $result = mysqli_query($conn,$query);
  while ($row = mysqli_fetch_assoc($result)) {
    $nominees[] = $row;
  }
?>

<!-- election date data -->
<?php
  $campus = $_SESSION['campus'];
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "SELECT * FROM tbelectiondate";
  $dates = array();
  $result = mysqli_query($conn,$query);
  while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = $row;
  }
  
?>

<!-- get the date and time in the db -->
<?php 
  $campus = $_SESSION['campus'];
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query = "SELECT * from tbelectiondate";
  $result = mysqli_query($conn,$query);

  while($row = mysqli_fetch_assoc($result)){
    $GLOBALS['sDate'] = $row['start_date'];
    $GLOBALS['eDate'] = $row['end_date'];
    $GLOBALS['sTime'] = $row['start_time'];
    $GLOBALS['eTime'] = $row['end_time'];

  }

  $conn -> close();

  include '../includes/getUsers.php';


?>


<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>USeP E-Voting | Manage Users</title>

    <!-- Bootstrap core CSS-->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css" rel="stylesheet">
    <link rel="icon" href="../img/usep_logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">

    <!-- font awesome cdn -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet"  type='text/css'>
    <link rel="stylesheet" href="../css/toastr.css">
    <link rel="stylesheet" href="../css/time.css">
      <link rel="stylesheet" href="../headerStyle.css">
    <style>
        .btn-primary,#logout{
        background:#A24D4D;color:white;border:none
      }
      .btn-primary:hover,#logout:hover{
        background:#7e0308
      }
      .pace {
      -webkit-pointer-events: none;
      pointer-events: none;

      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
   }

    .pace-inactive {
      display: none;
    }
    .pace .pace-progress {
      background: #b05a21;
      position: fixed;
      z-index: 2000;
      top: 0;
      right: 100%;
      width: 100%;
      height: 4px;
    }
    @media (max-width:767px)
    {
      #title{
        font-size: 20px;
      }
      #logo{
        width:15%;
      }

    }

      #Mabini{
        font-weight:bolder;
        color:white;
        background:#66BB6A;
        padding:5px;
        border-radius:0.2rem;
        font-size:14px;
      }

      #Tagum{
        font-weight:bolder;
        color:white;
        background:#26C6DA;
        padding:5px;
        border-radius:0.2rem;
        font-size:14px;
      }


      #Mabini-Watcher{
        font-weight:bolder;
        color:white;
        background:#66BB6A;
        padding:5px;
        border-radius:0.2rem;
        font-size:14px;
      }

      #Tagum-Watcher{
        font-weight:bolder;
        color:white;
        background:#26C6DA;
        padding:5px;
        border-radius:0.2rem;
        font-size:14px;
      }

      #Central-Chairperson{
        font-weight:bolder;
        color:white;
        background:#26C6DA;
        padding:5px;
        border-radius:0.2rem;
        font-size:14px;
      }

      #Technical-Officer{
        font-weight:bolder;
        color:white;
        background:#EA7600;
        padding:5px;
        border-radius:0.2rem;
        font-size:14px;
      }

      #Monitoring{
        font-weight:bolder;
        color:white;
        background:#6B14FF;
        padding:5px;
        border-radius:0.2rem;
        font-size:14px;
      }

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
            <img width="50%" src="../img/admin.png" alt=""><br><br>
            <span class="text-white "><?php if(isset($_SESSION['loggedName'])) echo ($_SESSION['loggedName']) ?></span> <span class="text-success font-weight-bold">● Online</span>
          </li><br>
        <li class="nav-item">
          <a class="nav-link" href="../central-admin/central_home.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item ">
          <a class="nav-link" href="../central-admin/central_view_candidates.php">
           <i class="fas fa-eye"></i>
            <span>View Candidates</span></a>
        </li>
        <div class="dropdown-divider"></div>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <span class="text-warning">Election Result</span></a>
          
            <!-- student council -->
          <li class="nav-item">
          <a class="nav-link" href="../central-admin/student_council_result.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Student Council</span></a>
          </li>

          <li class="nav-item">
          <a class="nav-link" href="../central-admin/local_council_result.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Local Council</span></a>
          </li>

            <div class="dropdown-divider"></div>
        <li class="nav-item active bg-danger">
          <a class="nav-link" href="../central-admin/manage_users.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Manage Users</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../central-admin/central_admin_system_logs.php">
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
        <br><br>
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
        <br><br>
        <li>
          <footer>
          <div class="card-body bg-dark text-white font-weight-bold">Logged in as <br><span class="text-success"><?php if(isset($_SESSION['username'])) echo strtolower($_SESSION['username']) ?></span></div>
          </footer>
        </li>
      </ul>

      <div id="content-wrapper" style=" background:url('../img/usep_bkg.jpg'); background-repeat: no-repeat; background-size: cover">
        <div class="container-fluid">

         <!-- Breadcrumbs-->
      <ol class="breadcrumb text-white font-weight-bold" >
            <li class="breadcrumb-item">
              <a href="#">Manage</a>
            </li>
            <li class="breadcrumb-item active">Users</li>
          </ol>


          <div class="card-body shadow-sm p-3 mb-12  bg-white rounded">
          <div id="buttons" class="card-header">
            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addUserModal" style="background:#438CCF;border:none"><i class="fa fa-plus" aria-hidden="true"></i> Add New User</button>
          </div>
          <br>
          <div class="table-responsive">
          <table id="usersTable" class="table  table-striped table-bordered" id="dataTable" width="100%"  cellspacing="0">
          <thead class="thead-dark">
          <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Username</th>
          <th>User Type</th>
          <th style="display:none">UserType2</th>
          <th style="display:none">ID</th>
          <th>Action</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach($users as $user) :  ?>
          <tr>
                <td><?= $user['firstName']; ?></td>
                <td><?= $user['lastName']; ?></td>  
                <td><?= $user['username']; ?></td>  
                <td><span id="<?= $user['role'] ?>"><?= $user['role'] ?></span></td>
                <td style="display:none"><?= $user['role']; ?></td>
                <td style="display:none"><?= $user['admin_id']; ?></td>
                <td></td>
          </tr>
          <?php endforeach; ?>
              </tbody>
              </table>
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
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
            <button class="btn btn-primary" id="savePass" ><i class="fa fa-floppy-o" aria-hidden="true"></i>
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
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
 Cancel</button>
            <a class="btn btn-primary" href="../admin/logout.php" id="logout"><i class="fa fa-sign-out" aria-hidden="true"></i>
 Logout</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Add User Modal-->
 <div>
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-white font-weight-bold" style="background:#8A3535">
            <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <i class="fa fa-times-circle" aria-hidden="true"></i>
            </button>
          </div>
          <div class="modal-body">
          
          <div class="form-group">
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-label-group">
                    <input type="text" name="firstName" id="firstName" class="form-control" placeholder="First Name" autofocus="autofocus">
                    <label for="firstName">First Name</label>
                  </div>
                </div>
              </div>
            </div> <!-- end of first name field -->

            <div class="form-group">
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-label-group">
                    <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Last Name" autofocus="autofocus">
                    <label for="lastName">Last Name</label>
                  </div>
                </div>
              </div>
            </div> <!-- end of last name field -->

            <!--user type select -->
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
             <select id="userType" name="userType" class="custom-select" id="inputGroupSelect04">
                <option selected value="Select User Type">Select User Type</option>
                <option value="Mabini">Mabini</option>
                <option value="Tagum">Tagum</option>
                <option value="Mabini-Watcher">Mabini Watcher</option>
                <option value="Tagum-Watcher">Tagum Watcher</option>
                <option value="Central-Chairperson">Central Chairperson</option>
                <option value="Monitoring">Monitoring</option>
                <option value="Technical-Officer">Technical Officer</option>

             </select>
            </div>
            </div>
            </div> <!-- end of user type select -->

            
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-label-group">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" autofocus="autofocus">
                    <label for="username">Username</label>
                  </div>
                </div>
              </div>
            </div> <!-- end of username field -->

             

            <div class="form-group">
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-label-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" autofocus="autofocus">
                    <label for="password">Password</label>
                  </div>
                </div>
              </div>
            </div> <!-- end of password field -->

            <div class="form-group">
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-label-group">
                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Confirm Password" autofocus="autofocus">
                    <label for="confirmPassword">Confirm Password</label>
                  </div>
                </div>
              </div>
            </div> <!-- end of confirm password field -->


          
          </div>
          <div class="modal-footer">
            <button id="saveUser"class="btn btn-success btn-block" style="background:#7E0308;border:none"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save User</button>
          </div>
          <p class="text-center text-secondary" style="font-size:14px">Tap outside to dismiss</p>
        </div>
      </div>
    </div>
    </div>


    <!-- Edit User Modal-->
 <div>
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header text-white font-weight-bold" style="background:#8A3535">
            <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <i class="fa fa-times-circle" aria-hidden="true"></i>
            </button>
          </div>
          <div class="modal-body">
          
          <div class="form-group">
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-label-group">
                    <input type="text" name="newFirstName" id="newFirstName" class="form-control" placeholder="First Name" autofocus="autofocus">
                    <label for="newFirstName">First Name</label>
                  </div>
                </div>
              </div>
            </div> <!-- end of first name field -->

            <div class="form-group">
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-label-group">
                    <input type="text" name="newLastName" id="newLastName" class="form-control" placeholder="Last Name" autofocus="autofocus">
                    <label for="newLastName">Last Name</label>
                  </div>
                </div>
              </div>
            </div> <!-- end of last name field -->

            <!--user type select -->
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
             <select id="newUserType" name="newUserType" class="custom-select" id="inputGroupSelect04">
                <option selected value="Select User Type">Select User Type</option>
                <option value="Mabini">Mabini</option>
                <option value="Tagum">Tagum</option>
                <option value="Mabini-Watcher">Mabini Watcher</option>
                <option value="Tagum-Watcher">Tagum Watcher</option>
                <option value="Central-Chairperson">Central-Chairperson</option>
                <option value="Monitoring">Monitoring</option>
                <option value="Technical-Officer">Technical-Officer</option>


             </select>
            </div>
            </div>
            </div> <!-- end of user type select -->

            
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-label-group">
                    <input type="text" name="newUsername" id="newUsername" class="form-control" placeholder="Username" autofocus="autofocus">
                    <label for="newUsername">Username</label>
                  </div>
                </div>
              </div>
            </div> <!-- end of username field -->



            <div class="form-group">
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-label-group">
                    <input type="password" name="newPassword" id="newPassword" class="form-control" placeholder="Password" autofocus="autofocus">
                    <label for="newPassword">Create New Password</label>
                  </div>
                </div>
              </div>
            </div> <!-- end of password field -->

            <div class="form-group">
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-label-group">
                    <input type="password" name="newConfirmPassword" id="newConfirmPassword" class="form-control" placeholder="Confirm Password" autofocus="autofocus">
                    <label for="newConfirmPassword">Confirm New Password</label>
                  </div>
                </div>
              </div>
            </div> <!-- end of confirm password field -->


          
          </div>
          <div class="modal-footer">
            <button id="saveUserUpdate"class="btn btn-success btn-block" style="background:#8A3535;border:none"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save User</button><br>
          </div>
          <p class="text-center text-secondary" style="font-size:14px">Tap outside to dismiss</p>

        </div>
      </div>
    </div>
    </div>


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
    <script src="../js/nominee_table.js"></script>

     <!-- date picker cdn -->
     <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

     <!-- loading preloader -->
     <script src="../js/pace.js"></script>
     <script src="../js/toastr.js"></script>
     <script src="../js/time.js"></script>


     <!-- sweet alert dialog -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

     <!-- chat room -->
     <div id="rt-8896a2e1910b867224e9470355f977b6" data-floating="true" data-side="right" data-width="700" data-height="500" data-counter="14,23"></div> <script src="https://rumbletalk.com/client/?HYtucjo~"></script>    <!-- script bar chart -->

     
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>



 <!-- // allscripts -->
 <script>
        $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>

<script>
        window.setTimeout(function() {
         $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);
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
            url: "../operations/election_date.php",
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
              toastr.warning("Please fill in all fields");
          }else{
            $.ajax({
            type: "POST",
            url: "../operations/central_admin_update_pass.php",
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

<script src="../scripts/manage_user_script.js"></script>

</body>

</html>
