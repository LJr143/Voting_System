<?php 
  session_start();
  error_reporting(0);
  date_default_timezone_set('Asia/Manila');
  include '../config/db_config.php';
  include '../includes/dashboard_add.php';


  if(!isset($_SESSION['username'])){
    header("location: ../index_admin.php");
  }
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
    
     <!-- include my own style -->
     <link href="../css/dashboard_style.css" rel="stylesheet">
     <link rel="stylesheet" href="../css/toastr.css">
     <link rel="stylesheet" href="../css/card-counter.css">
     <link rel="stylesheet" href="../css/time.css">
      <link rel="stylesheet" href="../headerStyle.css">
      <style>
          body {
              overflow-x: hidden;
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
  <div class=" main-header containerfluid text-white">
      <div class="row header-main" >
          <div class="col-md-8 px-5 d-flex align-content-center align-items-center ">
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

    <div id="wrapper" style=" background:url('../img/usep_bkg.jpg'); background-repeat: no-repeat; background-size: cover">
      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
      <li class="text-center">
            <img width="50%" src="../img/admin.png" alt=""><br><br>
            <span class="text-white "><?php if(isset($_SESSION['loggedName'])) echo ($_SESSION['loggedName']) ?></span> <span class="text-success font-weight-bold">● Online</span>
          </li><br>
        <li class="nav-item active bg-danger">
          <a class="nav-link" href="../tech-access/tech_home.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../tech-access/backup_db.php">
            <i class="fas fa-fw fa-database"></i>
            <span>Backup Database</span></a>
        </li>
        <br><br>
        <div class="nav-item">
          <div class="time bg-dark">
          <span class="hms"></span>
          <span class="ampm"></span>
          <br>
          <span class="date"></span>
      </div>
        </div>
        <br><br><br><br><br><br>
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
        <br><br><br><br><br><br><br><br><br><br>
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

          <div class="row">
        <div class="col-md-3 card-body">
          <div class="card-counter primary">
            <img width="25%" src="../img/campus_logos/obrero_logo.png" alt="">
            <span class="count-numbers"><?php echo $obreroCount ?></span>
            <span class="count-name">USeP Obrero Candidates</span>
          </div>
        </div>

        <div class="col-md-3 card-body">
          <div class="card-counter danger">
            <img width="25%" src="../img/campus_logos/mintal_logo.png" alt="">
            <span class="count-numbers"><?php echo $mintalCount ?></span>
            <span class="count-name">USeP Mintal Candidates</span>
          </div>
        </div>

        <div class="col-md-3 card-body">
          <div class="card-counter success">
            <img width="25%" src="../img/campus_logos/mabini_logo.png" alt="">
            <span class="count-numbers"><?php echo $mabiniCount ?></span>
            <span class="count-name">USeP Mabini Candidates</span>
          </div>
        </div>

        <div class="col-md-3 card-body">
          <div class="card-counter info">
            <img width="25%" src="../img/campus_logos/tagum_logo.png" alt="">
            <span class="count-numbers"><?php echo $tagumCount ?></span>
            <span class="count-name">USeP Tagum Candidates</span>
          </div>
        </div>
      </div>

          <div class="row">
            <div class="col-lg-8">
              <div class="card mb-3 shadow p-3 mb-5 bg-white rounded">
                <div id="priv" class="card-header text-white">
                  <i class="fas fa-chart-bar"></i>
                  VOTERS’ TURNOUT PER CAMPUS</div>
                <div class="card-body">
                  <canvas id="myBarChart" width="100%" height="50"></canvas>
                </div>
                <div class="card-footer small text-muted">Bar Graph shows the distribution of data between the total number of voters and the total number of voters who voted per campus</div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card mb-3 shadow p-3 mb-5 bg-white rounded">
                <div id="priv" class="card-header text-white">
                  <i class="fas fa-chart-pie"></i>
                  CAMPUS VOTERS’ TURNOUT</div>
                <div class="card-body">
                  <canvas id="myPieChart" width="100%" height="100"></canvas>
                </div>
                <div class="card-footer small text-muted">Pie Chart shows the distribution of data between the total number of voters who vote and total number of voters did not vote</div>
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
     <!-- Data privacy modal  -->
  <div class="modal animate__animated animate__bounceIn" data-backdrop="static" data-keyboard="false" id="privacy-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-header" style="background:#5F2D2D">
        <div class="modal-content">
          
          <div class="modal-body">
          <div class="text-center">
              <img src="../img/usep_logo.png" width="30%" alt="">
          </div>
              <div class="text-center">
                <h3>University of Southeastern Philippines</h3>
                <span>Office of Legal Affairs- Universiy Data Privacy Office</span><br><br>
                <h5 class="font-weight-bold">Privacy Notice</h5>
              </div>
            <br>
           <div class="text-center">
            <p>Pursuant to the University of Southeastern Philippines (USeP) data privacy policy and the Data Privacy Act of 2012,
             we will collect and process the following personal information from you when you manually or electronically fill in this form:</p>
           </div>
           <div>
            <ul>
              <li>Full Name</li>
              <li>E-mail address</li>
              <li>ID Number</li>
              <li>Campus, College and Program</li>
              <li>Birthdate</li>
              <li>Device Information</li>
            </ul>
           </div>

            <div class="text-center">
              <span><span class="font-weight-bold">USE:</span>The collected personal information will be utilized solely for <span class="text-danger">  2021 Campus Student Council Elections </span> </span>
            </div><br>

          <div>
            <span> <span class="font-weight-bold"> PROTECTION MEASURE: </span> These personal information shall be held in utmost confidentiality and shall not be transferred or 
            divulged to other persons or entity without your express consent. Only authorized personnel has access to this personal information. 
            <span class="text-danger"> The USeP – Commission on Student Election </span> will only retain the collected personal data as long as necessary for the fulfilment of the 
            purpose.</span>
          
          </div>

          <br>
         
            <br>
          <div class="text-center">
              <h5 class="font-weight-bold">Information</h5>
          </div>

          <div class="text-center">
            <p>For querries and clarifications pertaining to the University Data Privacy Policy and with the Data Privacy Act of 2012, 
            you may contact the Univeristy Data Privacy Officer <span class="font-weight-bold"> MR. KARLO MARTIN C. CARAMUGAN </span> through his email <a href="#"> kmccaramugan@usep.edu.ph </a> .</p>
          </div>

          </div>
          <div class="modal-footer">
            <div class="container text-center">
              <button type="button" class="btn btn-block" id="privacy" data-dismiss="modal">AGREE AND CONTINUE</button>
              <a href="https://www.usep.edu.ph/usep-data-privacy-statement/" target="_blank" class="btn btn-outline-secondary btn-block" style=>LEARN MORE</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>




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
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"
    />
    <script src="../js/toastr.js"></script>
    <script src="../js/time.js"></script>

    <!-- script bar chart -->
   <script>
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

var ctx = document.getElementById("myBarChart");
var myLineChart = new Chart(ctx, {
  type: 'bar',
  data: {
    
    labels: [<?php while ($row = mysqli_fetch_array($resultBar1)) { echo '"' . $row['campus'] . '",';}?>],
    datasets: [{
      label: "No. of Voters",
      backgroundColor: "#007AC7",
      borderColor: "rgba(2,117,216,1)",
      data: [<?php while ($row = mysqli_fetch_array($resultBar2)) { echo '"' . $row['COUNT(*)'] . '",';}?>],
    },

    {
            label: "Voters who actually voted",
            backgroundColor: "gray",
            data: [<?php while ($row = mysqli_fetch_array($resultBar4)) { echo '"' . $row['count(distinct studID)'] . '",';}?>],
    },
  
  ],

  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'month'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 6
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: <?php echo $vCount ?>,
          maxTicksLimit: 5
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: true
    }
  }
});
   </script> <!-- end of bar chart -->

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
            url: "../operations/tech_access_update_pass.php",
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
