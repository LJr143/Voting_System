<?php 
  session_start();
  error_reporting(0);
  include '../config/db_config.php';

  if(!isset($_SESSION['username'])){
    header("location: ../index_admin.php");
  }
?>
<!-- election date data -->
<?php
  $conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
  $query  = "SELECT * FROM tbelectiondate";
  $dates = array();
  $result = mysqli_query($conn,$query);
  while ($row = mysqli_fetch_assoc($result)) {
    $dates[] = $row;
  }
  $conn -> close();
  
?>

<?php
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$query = "SELECT * from tbelectiondate";
$result = mysqli_query($conn,$query);

while($row = mysqli_fetch_assoc($result)){
    $_SESSION['election_end'] = $row['end_date']." ".$row['end_time'];
} 
$currDT= str_replace(' ', '', date(" j F Y h:i A"));
$end = str_replace(' ', '', $_SESSION['election_end']);

// if($end != $currDT){
//   echo "Go to no data.php";
// }
 

$conn -> close();

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

?>

<!-- logs -->
<?php

$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$tempCampus = $_SESSION['username'];
$action = "Election Result | Access Denied";
$query = "INSERT into tblogs(name,action,timestamp)VALUES('$tempCampus','$action',Now())";
mysqli_query($conn, $query);

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">  
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>USeP E-Voting | Dashboard</title>

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
    <link rel="stylesheet" href="../css/toastr.css">
    <link rel="stylesheet" href="../css/time.css">

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
    @media (max-width:767px)
    {
      #title{
        font-size: 20px;
      }
      #logo{
        width:15%;
      }
      #img-rep{
        width:100%;
      }

    }
    </style>

  </head>
  <body id="page-top" onload = "fetchTime()">

    <nav class="navbar navbar-expand navbar-dark static-top">

    <img id="logo" width="2.5%" src="../img/usep_logo.png" alt="">
    <a id="title" class="navbar-brand mr-1" href="../central-admin/central_home.php"> USeP E-Voting</a>

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
            <img width="50%" src="../img/admin.png" alt=""><br>
            <span class="text-success font-weight-bold"><?php if(isset($_SESSION['username'])) echo strtolower($_SESSION['username']) ?></span>
          </li>
        <li class="nav-item">
          <a class="nav-link" href="../central-admin/central_home.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../central-admin/central_view_candidates.php">
            <i class="fas fa-fw fa-server"></i>
            <span>View Candidates</span></a>
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
        <br><br><br><br><br><br><br><br>
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
        <br><br><br><br><br>
        <li>
          <footer>
          <div class="card-body bg-dark text-white font-weight-bold">Logged in as <br><span class="text-success"><?php if(isset($_SESSION['username'])) echo strtolower($_SESSION['username']) ?></span></div>
          </footer>
        </li>
      </ul>

      <div id="content-wrapper">
        <div class="container-fluid">
          <div class="container">
            <img id="img-rep" class="rounded mx-auto d-block" src="../img/no_data.svg" width="50%" alt="">
          </div>
          <div class="text-center">
            Sorry, but the election result is not available at this moment. <br/>
            Try refreshing the page or click the button below to go back to Dashboard.
        <div><br/>
            <!-- <a class=" login-detail-panel-button btn" href="http://vultus.de/"> -->
            <a href="../central-admin/central_home.php" class="btn btn-primary" id="back"> <i class="fas fa-fw fa-tachometer-alt"></i></span> Go back to Dashboard</a>
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
            <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
 Cancel</button>
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
            <a class="btn btn-primary" href="../admin/logout.php" id="logout" ><i class="fa fa-sign-out" aria-hidden="true"></i>
 Logout</a>
          </div>
        </div>
      </div>
    </div>


    <div>
     <!-- election date modal -->
     <div class="modal fade" id="electionDateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
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
    
     <!-- loading preloader -->
     <script src="../js/pace.js"></script>
     
     <!-- date picker cdn -->
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

     <!-- sweet alert dialog -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
     <script src="../js/toastr.js"></script>
     <script src="../js/time.js"></script>

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


</body>

</html>
