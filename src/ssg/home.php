<?php 
  session_start();
  error_reporting(0);
  date_default_timezone_set('Asia/Manila');
  include '../config/db_config.php';
  include '../includes/ssg/home_ssg.php';

//   if(!isset($_SESSION['username'])){
//     header("location: ../index_admin.php");
//   }

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
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/toastr.css">
    <link rel="stylesheet" href="../css/card-counter.css">
    <link rel="stylesheet" href="../css/time.css">
    
  </head>
  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark static-top">
      
    <img id="logo" width="2.5%" src="../img/usep_logo.png" alt="">
    <a  id="title" class="navbar-brand mr-1" href="../ssg/home.php"> USeP E-Voting</a>

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
        <li class="nav-item active bg-danger">
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
        <li class="nav-item">
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
              <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

          <div class="">
              <div class="card mb-3 shadow p-3 mb-5 bg-white rounded">
                <div class="card-header text-white" id="priv">
                  <i class="fas fa-chart-pie"></i>
                  <?php echo ($_SESSION['campus']) ?> VOTERS’ TURNOUT</div>
                <div class="card-body">
                  <canvas id="myPieChart" width="100%" height="50%"></canvas>
                </div>
                <div class="card-footer small text-muted" >Pie Chart shows the distribution of data between the total number of voters who vote and total number of voters who did not vote in <?php echo $_SESSION['campus']." campus" ?> </div>
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


    <!-- change password modal -->
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
            <a class="btn btn-primary" href="../admin/logout.php" id="logout" ><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
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

    <!-- date picker cdn -->
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

     <!-- sweet alert dialog -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

     <!-- loading preloader -->
     <script src="../js/pace.js"></script>
     
     <!-- animate css -->
     <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>
    <script src="../js/toastr.js"></script>

    <!-- time -->
    <script src="../js/time.js"></script>

    <!-- chat room -->
    <div id="rt-8896a2e1910b867224e9470355f977b6" data-floating="true" data-side="right" data-width="700" data-height="500" data-counter="14,23"></div> <script src="https://rumbletalk.com/client/?HYtucjo~"></script>    <!-- script bar chart -->

   <!-- pie chart -->
<script>
  Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#292b2c';
  var ctx = document.getElementById("myPieChart");
  var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels:  ["Voters who did not vote","Voters who actually voted"],
      datasets: [{
        data: [<?php echo $resultPie7; ?>,<?php echo $resultPie4; ?>],
        backgroundColor: ['#007AC7','#FFA600'],
      }],
    },
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
              toastr.warning("Please fill in all fields");
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

<!-- modal opening -->
<script>
  $(window).on('load',function(){
    if (sessionStorage.getItem('dontLoad') == null){
      $('#privacy-modal').modal('show');
      sessionStorage.setItem('dontLoad', 'true');
    } 
    });
</script>
</body>
</html>
