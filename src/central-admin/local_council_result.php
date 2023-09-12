<?php 
  session_start();
  error_reporting(0);
  date_default_timezone_set('Asia/Manila');
  include '../config/db_config.php';
  require_once '../includes/central_election_result_add.php';


  if(!isset($_SESSION['username'])){
    header("location: ../index_admin.php");
  }


  $currDT= strtotime(date(" j F Y h:i"));

  // if(isset($_SESSION['election_end'])){
  //   $electionEnd = strtotime($_SESSION['election_end']);
  // }else{
  //   echo "
  //   <script>window.location = 'central_no_data.php'; </script> ";
  // }
  // echo $currDT;
  // echo "</br>";
  // echo $electionEnd;

  // check if current date and election date matched
  // echo $result;
  // if($currDT < $electionEnd){
  //    header("Location: central_no_data.php");
  // }

?>

<!DOCTYPE html>
<html lang="en">  
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>USeP E-Voting | Election Result</title>

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

    <link rel="stylesheet" href="../css/election_result.css">
    <link rel="stylesheet" href="../css/toastr.css">
    <link rel="stylesheet" href="../css/time.css">
      <link rel="stylesheet" href="../headerStyle.css">

    <script>

      function fetchTime(){
        var dt=  new Date().toLocaleTimeString();
        document.getElementById('timeUpdate').innerHTML = "Updated today at " + dt;
        document.getElementById('timeUpdate2').innerHTML = "Updated today at " + dt;

      }
    
    </script>

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

    #nav-tab{
        background: rgb(138,53,53);
        background: linear-gradient(90deg, rgb(23, 3, 3) 0%, rgb(112, 6, 6) 35%, rgb(180, 86, 86) 100%);
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
      #obreronominees_filterSelect2, #mabininominees_filterSelect3,#mintalnominees_filterSelect3,#tagumnominees_filterSelect3,
      #localobreronominees_filterSelect,#localmabininominees_filterSelect2,#localmintalnominees_filterSelect2,#localtagumnominees_filterSelect2,
      #localmabininominees_filterSelect3,#localmintalnominees_filterSelect3,#localtagumnominees_filterSelect3,
      #localmabininominees_filterSelect4,#localmintalnominees_filterSelect4,#localtagumnominees_filterSelect4{
        max-width:50% !important; 
      }
      #obreronominees_filterWrapper,#mabininominees_filterWrapper, #mintalnominees_filterWrapper, #tagumnominees_filterWrapper,
      #localobreronominees_filterWrapper, #localmabininominees_filterWrapper, #localmintalnominees_filterWrapper, #localtagumnominees_filterWrapper{
        margin-bottom:5px !important;
        padding:5px !important;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        border-radius: 5px; 
      }

      #img{
      cursor:zoom-in;
      cursor:-webkit-zoom-in;
      cursor:-moz-zoom-in;
      width:100px;
    }
    
    #voteCount{
        font-weight:bolder;
        color:white;
        background:green;
        padding:5px;
        border-radius:0.2rem;
        font-size:16px;
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
        <li class="nav-item">
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

          <li class="nav-item active bg-danger">
          <a class="nav-link" href="../central-admin/local_council_result.php">
            <i class="fas fa-fw fa-users"></i>
            <span>Local Council</span></a>
          </li>
            <div class="dropdown-divider"></div>
        </li>
        <li class="nav-item">
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
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">View Result</a>
            </li>
            <li class="breadcrumb-item active">Election Result</li>
          </ol>

      <div class="container text-white">
            <div class="row">
            <div class="col text-center">
            <img class="animate__animated animate__pulse animate__infinite	infinite" src="../img/usep_logo.png" width="50%" alt="">
            </div>
            <div class="col-6 text-center">
              <h5>UNIVERSITY OF SOUTHEASTERN PHILIPPINES</h5><hr>
            <h5>COMMISSION ON ELECTION</h5><br>
            <p class="font-weight-bold">Election result as of <?php  echo date("F d, Y") ?></p>
            </div>
            <div class="col">
            <img class="animate__animated animate__pulse animate__infinite	infinite" src="../img/COC Logo2.png" width="50%" alt="">
            </div>
      </div>
    </div>
        
          <section id="tabs" class="project-tab">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill card-body bg-success" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-localmabini-tab" data-toggle="tab" href="#nav-localmabini" role="tab" aria-controls="nav-localmabini" aria-selected="false">Mabini Campus</a>
                                <a class="nav-item nav-link" id="nav-localtagum-tab" data-toggle="tab" href="#nav-localtagum" role="tab" aria-controls="nav-localtagum" aria-selected="false">Tagum Campus</a>

                            </div>
                        </nav>
                        <div class="tab-content text-white" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-localmabini" role="tabpanel" aria-labelledby="nav-localmabini-tab">
                            <br>
                            <!-- local council mabini -->
                            <div id="localmabinibuttons"></div><br>
                            <div style="height: 600px; width: 100%;overflow-y: auto;">
                            <table id="localmabininominees" class="table table-bordered table-striped justify-content-center">
                            <thead class="thead-dark">
                            <tr>
                              <th></th>
                              <th>Candidate</th>
                              <th>College</th>
                              <th>Program</th>
                              <th>Position</th>
                              <th>Total Votes</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php foreach($localmabinistudents as $nominee) :  ?>
                          <tr>
                                <td>
                                <a href="#" class="pop">
                                <img id="img" data-toggle="tooltip" title="Click to enlarge" class="border " width="60px" src="../uploads/<?= $nominee['image']; ?>" alt="">
                                </a>
                                </td>
                                <td><?= $nominee['nameCand']; ?></td>
                                <td><?= $nominee['college']; ?></td>
                                <td><?= $nominee['program']; ?></td>
                                <td><?= $nominee['position']; ?></td>
                                <td><span id="voteCount"><?= $nominee['COUNT(*)']; ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                            </div>
                                
                            </div>
                            <div class="tab-pane fade" id="nav-localtagum" role="tabpanel" aria-labelledby="nav-localtagum-tab">
                                <br>
                                <!-- student council tagum -->
                                <div id="localtagumbuttons"></div><br>
                                <div style="height: 600px; width: 100%;overflow-y: auto;">
                                <table id="localtagumnominees" class="table table-bordered table-striped">
                                <thead class="thead-dark">
                                <tr>
                                  <th class="text-center"></th>
                                  <th class="text-center">Candidate</th>
                                  <th class="text-center">College</th>
                                  <th class="text-center">Program</th>
                                  <th class="text-center">Position</th>
                                  <th class="text-center">Total Votes</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php foreach($localtagumstudents as $nominee) :  ?>
                              <tr>
                                    <td class="text-center">
                                    <a href="#" class="pop">
                                    <img id="img" data-toggle="tooltip" title="Click to enlarge" class="border " width="60px" src="../uploads/<?= $nominee['image']; ?>" alt="">
                                    </a>
                                    </td>
                                    <td class="text-center"><?= $nominee['nameCand']; ?></td>
                                    <td class="text-center"><?= $nominee['college']; ?></td>
                                    <td class="text-center"><?= $nominee['program']; ?></td>
                                    <td class="text-center"><?= $nominee['position']; ?></td>
                                    <td class="text-center"><span id="voteCount"><?= $nominee['COUNT(*)']; ?></span></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


         
            
          </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->

      </div>
      <!-- /.content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <div>

    <!-- modal for image zoom -->
    <div>
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">              
        <div class="modal-body">
          <img src="" class="imagepreview" style="width: 100%;" >
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
            <a class="btn btn-primary" href="../admin/logout.php" id="logout" ><i class="fa fa-sign-out" aria-hidden="true"></i>
 Logout</a>
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
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times-circle" aria-hidden="true"></i>
 Cancel</button>
            <button class="btn btn-primary" id="savePass" ><i class="fa fa-floppy-o" aria-hidden="true"></i>
 Save Changes</button>
          </div>
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

     <!-- datatable buttons -->
     <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin.min.js"></script>

     <!-- date picker cdn -->
     <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

     <!-- loading preloader -->
     <script src="../js/pace.js"></script>

     <!-- data table custom filtering -->
     <script src="../js/filterDropDown.js"></script>


     <!-- sweet alert dialog -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

     <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"
    />
    <script src="../js/toastr.js"></script>
    <script src="../js/time.js"></script>

    <!-- chat room -->
    <div id="rt-8896a2e1910b867224e9470355f977b6" data-floating="true" data-side="right" data-width="700" data-height="500" data-counter="14,23"></div> <script src="https://rumbletalk.com/client/?HYtucjo~"></script>    <!-- script bar chart -->


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


 <!-- local council datatables -->
 <!-- mabini  -->
<script>
 
 $(document).ready( function () {
   var table =  $('#localmabininominees').DataTable({
        language: {
        searchPlaceholder: "Search candidate"
    },
    filterDropDown: {										
						columns: [
              { 
								idx: 4
							},
              { 
								idx: 2
							},
              { 
								idx: 3
							},
						],
						bootstrap: true
					}
    
    });

    var buttons = new $.fn.dataTable.Buttons(table, {
      buttons: [
            {
                extend:'excel',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel',
                className: 'btn btn-outline-success',
                titleAttr:'Export to Excel',
                title:'election-result_'+ new Date($.now())
            },
            {
                extend:'print',
                text: '<i class="fa fa-print" aria-hidden="true"></i> Print',
                className: 'btn btn-outline-success',
                titleAttr:'Print Result',
                title:'election-result_'+ new Date($.now())
            },
        ]
}).container().appendTo($('#localmabinibuttons'));
} );
 </script>


  <!-- tagum -->
<script>
 
 $(document).ready( function () {
   var table =  $('#localtagumnominees').DataTable({
        language: {
        searchPlaceholder: "Search candidate"
    },
    filterDropDown: {										
						columns: [
							{ 
								idx: 4
							},
              { 
								idx: 2
							},
              { 
								idx: 3
							},
						],
						bootstrap: true
					}
    
    });

    var buttons = new $.fn.dataTable.Buttons(table, {
      buttons: [
            {
                extend:'excel',
                text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel',
                className: 'btn btn-outline-success',
                titleAttr:'Export to Excel',
                title:'election-result_'+ new Date($.now())
            },
            {
                extend:'print',
                text: '<i class="fa fa-print" aria-hidden="true"></i> Print',
                className: 'btn btn-outline-success',
                titleAttr:'Print Result',
                title:'election-result_'+ new Date($.now())
            },
        ]
}).container().appendTo($('#localtagumbuttons'));
} );
 </script>


<!-- image zoom -->
<script>
 $(function() {
		$('.pop').on('click', function() {
			$('.imagepreview').attr('src', $(this).find('img').attr('src'));
			$('#imagemodal').modal('show');   
		});		
});
 
 </script>


</body>
</html>
