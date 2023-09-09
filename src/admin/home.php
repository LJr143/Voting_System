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
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/toastr.css">
    <link rel="stylesheet" href="../css/card-counter.css">
    <link rel="stylesheet" href="../css/time.css">
      <link rel="stylesheet" href="../headerStyle.css">

    
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
        <li class="nav-item active bg-danger">
          <a class="nav-link" href="../admin/home.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
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
              <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

         <!-- Icon Cards-->
        <?php $campus = $_SESSION['campus']; ?>
         <div class="row">
        <div class="col-md-3 card-body">
          <div class="card-counter primary">
            <img width="25%" src="../img/campus_logos/tagum_logo.png" alt="">
            <span class="count-numbers"><?php echo  $resultPie2?></span>
            <span class="count-name">USeP <?php echo $_SESSION['campus'] ?>  Total No. Voters</span>
          </div>
        </div>

<!--        <div class="col-md-3 card-body">-->
<!--          <div class="card-counter danger">-->
<!--            <img width="25%" src="../img/campus_logos/tagum_logo.png" alt="">-->
<!--            <span class="count-numbers">--><?php //echo $resultPie4?><!--</span>-->
<!--            <span class="count-name">USeP --><?php //echo $_SESSION['campus'] ?><!--  Total Vote Cast</span>-->
<!--          </div>-->
<!--        </div>-->

        <div class="col-md-3 card-body">
          <div class="card-counter success">
            <img width="25%" src = "../img/campus_logos/tagum_logo.png"; alt="">
            <span class="count-numbers"><?php echo $resultPie2 - $resultPie4 ?></span>
            <span class="count-name">USeP <?php echo $_SESSION['campus'] ?>  Vote to Cast</span>
          </div>
        </div>

        <div class="col-md-3 card-body">
          <div class="card-counter info">
            <img width="25%" src="../img/campus_logos/tagum_logo.png" alt="">
            <span class="count-numbers"><?php echo $percentageFilledSC ?>%</span>
            <span class="count-name">USeP <?php echo $_SESSION['campus'] ?>  Candidates SC</span>
          </div>
        </div>
             <div class="col-md-3 card-body">
                 <div class="card-counter danger">
                     <img width="25%" src="../img/campus_logos/tagum_logo.png" alt="">
                     <span class="count-numbers"><?php echo $percentageFilled ?>%</span>
                     <span class="count-name">USeP <?php echo $_SESSION['campus'] ?>  Candidates LC</span>
                 </div>
             </div>
      </div>

          <div class="row">
<!--            <div class="col-lg-8">-->
<!--              <div class="card mb-3 shadow p-3 mb-5 bg-white rounded">-->
<!--                <div id="priv" class="card-header text-white">-->
<!--                  <i class="fas fa-chart-bar"></i>-->
<!--                  VOTERS’ TURNOUT   </div>-->
<!--                <div class="card-body">-->
<!--                  <canvas id="myBarChart" width="100%" height="50"></canvas>-->
<!--                </div>-->
<!--                <div class="card-footer small text-muted">Bar Graph shows the distribution of data between the total number of voters and the total number of voters who voted per college</div>-->
<!--              </div>-->
<!--            </div>-->
              <div class="col-md-8">
                  <div class="card mb-3 shadow p-3 mb-5 bg-white rounded">
                      <div class="card-header text-white" id="priv">
                          <i class="fas fa-chart-pie"></i>
                          VOTERS’ TURNOUT PER PROGRAM
                      </div>
                      <div class="card-body" style="text-align: center">
                          <canvas id="myPieChart1" width="100%" height="48.5"></canvas>
                      </div>
                      <div class="card-footer small text-muted">
                          Pie Chart shows the distribution of voters per program
                      </div>
                  </div>
              </div>
            <div class="col-lg-4">
              <div class="card mb-3 shadow p-3 mb-5 bg-white rounded">
                <div class="card-header text-white" id="priv">
                  <i class="fas fa-chart-pie"></i>
                  CAMPUS VOTERS’ TURNOUT</div>
                <div class="card-body">
                  <canvas id="myPieChart" width="100%" height="100"></canvas>
                </div>
                <div class="card-footer small text-muted" >Pie Chart shows the distribution of data between the total number of voters who vote and total number of voters who did not vote in <?php echo $_SESSION['campus']." campus" ?> </div>
              </div>
            </div>
              <div class="col-lg-12">
                  <div class="card mb-3 shadow p-3 mb-5 bg-white rounded">
                      <div class="card-header text-white" id="priv">
                          <i class="fas fa-chart-pie"></i>
                          CAMPUS VOTERS’ TURNOUT PER PROGRAM</div>
                      <div class="card-body">
                          <canvas id="votersWhoVotedPieChart" width="100%" height="30"></canvas>
                      </div>
                      <div class="card-footer small text-muted" >Pie Chart shows the number of voter who already voted per program <?php echo $_SESSION['campus']." campus" ?> </div>
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

  </div>
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
            <a class="btn btn-primary" href="../admin/logout.php" id="logout" ><i class="fa fa-sign-out" aria-hidden="true"></i>
 Logout</a>
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

    <!-- time -->
    <script src="../js/time.js"></script>


      <script>
          Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
          Chart.defaults.global.defaultFontColor = '#292b2c';


          // Create separate chart for each campus
          var ctxTagum = document.getElementById("myBarChart");
            var campusS = '<?php echo $_SESSION["campus"]?>';
          if(campusS === 'Tagum') {
              var tagumChart = new Chart(ctxTagum, {
                  type: 'bar',
                  data: {
                      labels: [<?php while ($row = mysqli_fetch_array($resultBar1Tagum)) {
                          echo '"' . $row['campus'] . '",';
                      } ?>],
                      datasets: [
                          {
                              label: "No. of Voters",
                              backgroundColor: "#670707",
                              borderColor: "rgb(103,7,7)",
                              data: [<?php while ($row = mysqli_fetch_array($resultBar2Tagum)) {
                                  echo '"' . $row['tt_voter_tagum'] . '",';
                              }?>],
                          },
                          {
                              label: "Voters who actually voted (Tagum)",
                              backgroundColor: "#170688",
                              data: [<?php while ($row = mysqli_fetch_array($resultBar3Tagum)) {
                                  echo '"' . $row['count'] . '",';
                              } ?>],
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
                                  maxTicksLimit: 6,
                                  fontColor: 'white'
                              }
                          }],
                          yAxes: [{
                              ticks: {
                                  min: 0,
                                  maxTicksLimit: 5,
                                  fontColor: 'white'
                              },
                              gridLines: {
                                  display: true
                              }
                          }],
                      },
                      legend: {
                          display: true,
                          labels: {
                              fontColor: 'white'
                          }
                      }
                  }
              });
          }else  {
              var tagumChart = new Chart(ctxTagum, {
                  type: 'bar',
                  data: {
                      labels: [<?php while ($row = mysqli_fetch_array($resultBar1Mabini)) {
                          echo '"' . $row['campus'] . '",';
                      } ?>],
                      datasets: [
                          {
                              label: "No. of Voters",
                              backgroundColor: "#670707",
                              borderColor: "rgb(103,7,7)",
                              data: [<?php while ($row = mysqli_fetch_array($resultBar2Mabini)) {
                                  echo '"' . $row['tt_voter_mabini'] . '",';
                              }?>],
                          },
                          {
                              label: "Voters who actually voted (Mabini)",
                              backgroundColor: "#170688",
                              data: [<?php while ($row = mysqli_fetch_array($resultBar3Mabini)) {
                                  echo '"' . $row['count'] . '",';
                              } ?>],
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
                                  maxTicksLimit: 6,
                                  fontColor: 'white'
                              }
                          }],
                          yAxes: [{
                              ticks: {
                                  min: 0,
                                  maxTicksLimit: 5,
                                  fontColor: 'white'
                              },
                              gridLines: {
                                  display: true
                              }
                          }],
                      },
                      legend: {
                          display: true,
                          labels: {
                              fontColor: 'white'
                          }
                      }
                  }
              });
          }

      </script> <!-- end of bar chart -->

   <!-- pie chart -->
      <script>
          <?php
          $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
          $queryPrograms = "SELECT p.college_program_name, COUNT(*) as program_count FROM tb_voter v
        JOIN college_program p ON v.program_id = p.program_id
        WHERE v.campus = 'Tagum'
        GROUP BY v.program_id";
          $resultPrograms = mysqli_query($conn, $queryPrograms);

          $labelsPrograms = [];
          $dataPrograms = [];
          while ($row = mysqli_fetch_array($resultPrograms)) {
              $labelsPrograms[] = $row['college_program_name'];
              $dataPrograms[] = $row['program_count'];
          }

          $conn->close();
          ?>
          var ctxPie = document.getElementById("myPieChart1");
          var pieChart = new Chart(ctxPie, {
              type: 'pie',
              data: {
                  labels: <?php echo json_encode($labelsPrograms); ?>,
                  datasets: [{
                      data: <?php echo json_encode($dataPrograms); ?>,
                      backgroundColor: ['#007AC7', '#00C853', '#FFC107', '#FF5722', '#9C27B0', '#673AB7', '#2196F3'],
                      borderColor: '#fff',
                      borderWidth: 1
                  }]
              },
              options: {
                  plugins: {
                      legend: {
                          position: 'right',
                          labels: {
                              fontColor: 'white'
                          }
                      },
                      datalabels: {
                          formatter: (value, ctx) => {
                              let label = ctx.chart.data.labels[ctx.dataIndex];
                              return label + ": " + value + " votes";
                          },
                          color: '#fff',
                          anchor: 'end',
                          align: 'start',
                          offset: 10,
                          labels: {
                              title: {
                                  font: {
                                      weight: 'bold'
                                  }
                              }
                          }
                      }
                  }
              }
          });
      </script>
      <?php
      // Assuming you have a database connection established
      $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      $query = "SELECT cp.college_program_name,
       COUNT(DISTINCT tv.studID) as voted
FROM tb_voter v
JOIN college_program cp ON v.program_id = cp.program_id
LEFT JOIN tb_votes tv ON v.stud_id = tv.studID
WHERE v.campus = 'Tagum'
GROUP BY cp.college_program_name;";
      $result = mysqli_query($conn, $query);

      $labels = [];
      $data = [];

      while ($row = mysqli_fetch_assoc($result)) {
          $labels[] = $row['college_program_name'];
          $data[] = $row['voted'];
      }

      $conn->close();
      ?>

      <script>
          var ctxPie = document.getElementById("votersWhoVotedPieChart");

          var pieChart = new Chart(ctxPie, {
              type: 'pie',
              data: {
                  labels: <?php echo json_encode($labels); ?>,
                  datasets: [{
                      data: <?php echo json_encode($data); ?>,
                      backgroundColor: ['#007AC7', '#00C853', '#FFC107', '#FF5722', '#9C27B0', '#673AB7', '#2196F3'],
                      borderColor: '#fff',
                      borderWidth: 1
                  }]
              },
              options: {
                  plugins: {
                      legend: {
                          position: 'right',
                          labels: {
                              fontColor: 'white'
                          }
                      },
                      datalabels: {
                          formatter: (value, ctx) => {
                              let label = ctx.chart.data.labels[ctx.dataIndex];
                              return label + ": " + value + " voters voted";
                          },
                          color: '#fff',
                          anchor: 'end',
                          align: 'start',
                          offset: 10,
                          labels: {
                              title: {
                                  font: {
                                      weight: 'bold'
                                  }
                              }
                          }
                      }
                  }
              }
          });
      </script>

      <script>
  Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#292b2c';
  var ctx = document.getElementById("myPieChart");
  var campusS = '<?php echo $_SESSION["campus"]?>';
  if(campusS === 'Tagum') {
      var myPieChart = new Chart(ctx, {
          type: 'pie',
          data: {
              labels: ["Voters who did not vote", "Voters who actually voted"],
              datasets: [{
                  data: [<?php echo $resultPie7; ?>,<?php echo $resultPie4; ?>],
                  backgroundColor: ['#007AC7', '#FFA600'],
              }],
          },
      });
  }else {
      var myPieChart = new Chart(ctx, {
          type: 'pie',
          data: {
              labels: ["Voters who did not vote", "Voters who actually voted"],
              datasets: [{
                  data: [<?php echo $resultPie7; ?>,<?php echo $resultPie4; ?>],
                  backgroundColor: ['#007AC7', '#FFA600'],
              }],
          },
      });
  }
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
