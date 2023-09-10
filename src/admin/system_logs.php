<?php
session_start();
error_reporting(0);
require_once("../excel_script/db-class.php");
require_once("../excel_script/xlsxwriter.class.php");
ini_set("display_errors", 1);
ini_set("log_errors", 1);
//error_reporting(E_ALL & ~E_NOTICE);
date_default_timezone_set('Asia/Manila');

if(!isset($_SESSION['username'])){
    header("location: ../index_admin.php");
}


if(isset($_POST['export'])){
    function getData() {
        $tempUsername = $_SESSION['username'];
        $db = new MY_SQLDB();
        $sql = "SELECT log_action_date,name,action from tb_admin_ation_logs where name = '$tempUsername' ";
        $rows = $db->get_rows($sql);
        $sheet_titles = $db->get_column_names();
        $data = array_merge(array(), $rows);
        array_unshift($data , $sheet_titles);
        $db->close_connection();
        return $data;
    }

    $data = getData();
    $filename = "system_logs"."_".date("Y-m-d").".xlsx";

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

?>

<!-- clear logs -->

<?php
$user = $_SESSION['username'] ;
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$query = "DELETE tb_admin_action_logs
FROM tb_admin_action_logs
LEFT JOIN tbadmin ON tbadmin.admin_id = tb_admin_action_logs.admin_id
WHERE tbadmin.username = '$user'";
if(isset($_POST['empty'])){
    mysqli_query($conn,$query);
}

$conn -> close();
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

<?php
error_reporting(0);

$temp = $_SESSION['username'];
$conn = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$query  = "SELECT *,tbadmin.username FROM tb_admin_action_logs 
LEFT JOIN tbadmin ON tb_admin_action_logs.admin_id
WHERE tbadmin.admin_id = tb_admin_action_logs.admin_id
AND  tbadmin.username = '$temp'
ORDER BY log_action_date DESC";
$nominees = array();
$result = mysqli_query($conn,$query);
while ($row = mysqli_fetch_assoc($result)) {
    $logs[] = $row;
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

    <title>USeP E-Voting | Logs</title>

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
        #priv{
            background: rgb(138,53,53);
            background: linear-gradient(90deg, rgba(138,53,53,1) 0%, rgba(196,95,95,1) 35%, rgba(138,53,53,1) 100%);
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

<div id="wrapper" style=" background:url('../img/usep_bkg.jpg'); background-repeat: no-repeat; background-size: cover"  >
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
        <li class="nav-item active bg-danger">
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
                    <a href="#">System Logs</a>
                </li>
                <li class="breadcrumb-item active">User Activities</li>
            </ol>


            <div class="card shadow p-3 bg-white rounded">
                <div class="breadcrumb"><form method="post"><button class="btn btn-success float-left" name="export"><i class="fa fa-file-excel-o" aria-hidden="true"></i>
                            Export Data</button> </form>
                    <button class="btn btn-danger float-left" data-toggle="modal" data-target="#clearModal"><i class="fas fa-broom aria-hidden="true"></i>
                        Empty List</button>
                </div>
                <div id="priv" class="card-header text-white"><i class="fas fa-table"></i> System Activites</div>
                <div class="card-body">
                    <div style="height: 600px; width: 100%;overflow-y: auto;">
                        <table id="logs" class="table table-bordered">
                            <thead class="thead-dark">
                            <tr>
                                <th><i class="fa fa-clock-o" aria-hidden="true"></i> TIMESTAMP</th>
                                <th><i class="fa fa-user" aria-hidden="true"></i> NAME</th>
                                <th><i class="fa fa-history" aria-hidden="true"></i> ACTION/S</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($logs as $log) :  ?>
                                <tr>
                                    <td>
                                        <?= date('g:i a | m-d-Y', strtotime($log['log_action_date'])); ?>
                                    </td>
                                    <td><?= $log['username'] ?></td>
                                    <td><?= $log['action']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
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

    <!-- clear logs modal -->

    <div>

        <!-- Delete Modal -->
        <div class="modal fade" id="clearModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                        <h5 class="text-center">Select "Okay" if you want to remove logs permanently</h5>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
                            Cancel</button>
                        <form method="post"><button type="submit" class="btn btn-primary" id="empty" name="empty"><i class="fa fa-check" aria-hidden="true"></i>
                                Okay</button></form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>

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

    <!-- loading preloader -->
    <script src="../js/pace.js"></script>


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
        $(document).ready(function() {
            $('#logs').DataTable( {
                "order": [[ 1, "desc" ]],
                language: {
                    searchPlaceholder: "Search records"
                }
            } );
        } );
    </script>

</body>
</html>
