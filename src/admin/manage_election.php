<?php
    session_start();
    date_default_timezone_set('Asia/Manila');
    require_once '../config/db_config.php';
    include '../includes/add_org_add.php';
    error_reporting(0);
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

    <title>USeP E-Voting | Manage Election</title>

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

    <!-- include tab styles -->
    <link rel="stylesheet" href="../css/tab.css">
    <link rel="stylesheet" href="../css/add_org.css">
    <link rel="stylesheet" href="../css/toastr.css">
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
        <li class="nav-item active bg-danger">
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
      <div class="container-fluid text-white">
       <!-- Breadcrumbs-->
       <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Election</a>
            </li>
            <li class="breadcrumb-item active">Manage Election</li>
          </ol>

       <div class="col-12 card-body text-center bg-dark text-white">
       
        <button class="btn btn-secondary" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus-circle" aria-hidden="true"></i>
          Add Party</button>
        <button class="btn btn-secondary" data-toggle="modal" data-target="#addPositionModal"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Local Council Position</button>
        <button class="btn btn-secondary" data-toggle="modal" data-target="#addCouncilPositionModal"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Student Council Position</button>
           <button class="btn btn-secondary" data-toggle="modal" data-target="#addSOMCouncilPositionModal"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add SOM Student Council Position</button>

       </div>

      <br>

    
        <?php 
        if(isset($_POST['submit']))
        if($success == 'true'){
            ?>
            <script type='text/javascript'>
            window.onload = function(){
              document.getElementById("success").style.display = "block";
        }
        </script>
        <?php
       
      }else{
        ?>
        <script type='text/javascript'>
        window.onload = function(){
            document.getElementById("error").style.display = "block";
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
            <button class="btn btn-primary" id="savePass" ><i class="fa fa-floppy-o" aria-hidden="true"></i>
 Save Changes</button>
          </div>
        </div>
      </div>
    </div>
    </div>


    <div>
      <!-- add position Modal-->
      <div class="modal fade" id="addPositionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Position</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
            </button>
          </div>
          <div class="modal-body">
          <div style="background:#CC6464; color:white" class="card-header"><i class="fas fa-object-group"></i> Add Local Council Position</div>
          <div class="card-body">
         <div  id="addPoliticalPartyForm">
            <!-- polictical party field -->
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
            <div class="form-label-group">
              <input type="text" name="position" id="position" class="form-control" placeholder="Position Name">
              <label for="position">Position Name</label>
              <span id = "errorPosition"style ="color:red;"></span>
            </div>
            </div>
            </div>
            </div> <!-- end of politacl party field -->
          </div> <!-- end of form -->
          </div>
          <div class="modal-footer">
            <button id="addPosition" class="btn btn-block" name="submit" type="submit" ><i class="fa fa-plus" aria-hidden="true"></i>
 Submit</button>
          </div>
        </div>
      </div>
    </div>
    </div>

    
    <div>
      <!-- add student council position Modal-->
      <div class="modal fade" id="addCouncilPositionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Position</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
            </button>
          </div>
          <div class="modal-body">
          <div style="background:#CC6464; color:white" class="card-header"><i class="fas fa-object-group"></i> Add Student Council Position</div>
          <div class="card-body">
         <div  id="addPoliticalPartyForm">
            <!-- polictical party field -->
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
            <div class="form-label-group">
              <input type="text" name="councilPosition" id="councilPosition" class="form-control" placeholder="Position Name">
              <label for="councilPosition">Position Name</label>
              <span id = "errorCouncilPosition"style ="color:red;"></span>
            </div>
            </div>
            </div>
            </div> <!-- end of politacl party field -->
          </div> <!-- end of form -->
          </div>
          <div class="modal-footer">
            <button id="addCampusPosition" class="btn btn-block" name="submit" type="submit" ><i class="fa fa-plus" aria-hidden="true"></i> Submit</button>
          </div>
        </div>
      </div>
    </div>
    </div>
        <!-- add School of Medicine student council position Modal-->
        <div class="modal fade" id="addSOMCouncilPositionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Position</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div style="background:#CC6464; color:white" class="card-header"><i class="fas fa-object-group"></i> Add School of Medicine Student Council Position</div>
                        <div class="card-body">
                            <div  id="addPoliticalPartyForm">
                                <!-- polictical party field -->
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-label-group">
                                                <input type="text" name="somcouncilPosition" id="somcouncilPosition" class="form-control" placeholder="Position Name">
                                                <label for="somcouncilPosition">Position Name</label>
                                                <span id = "errorCouncilPosition"style ="color:red;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end of politacal party field -->
                            </div> <!-- end of form -->
                        </div>
                        <div class="modal-footer">
                            <button id="addSOMCampusPosition"  class="btn btn-block" name="submit" type="submit" ><i class="fa fa-plus" aria-hidden="true"></i> Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- position add and edit modal -->
    <div>
         <!-- Edit Modal -->
     <div class="modal fade" id="editPositionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
          Edit Local Council Position</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" method="post">
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
            <div class="form-label-group">
                <input type="text" name="newPosition" id="newPosition" class="form-control" placeholder="New Position Name" autofocus="autofocus">
                <label for="newPosition">New Position Name</label>
            </div>
            </div>
            </div>
            </div> <!-- end of position field -->
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
 Cancel</button>
            <button type="button" class="btn btn-primary" id="savePositionChange"><i class="fa fa-floppy-o" aria-hidden="true"></i>
 Save changes</button>
        </div>
        </div>
    </div>
    </div>
        <!-- Delete Modal -->
     <div class="modal fade" id="deletePositionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
           <h5 class="text-center">Are you sure you want to delete it?</h5>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
 Cancel</button>
            <button type="button" class="btn btn-primary"  id="savePositionDelete"><i class="fa fa-check" aria-hidden="true"></i>
 Yes</button>
        </div>
        </div>
    </div>
    </div>
    </div>

    <!-- council position add and edit modal -->
    <div>
         <!-- Edit Modal -->
     <div class="modal fade" id="editCouncilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
          Edit Student Council Position</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" method="post">
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
            <div class="form-label-group">
                <input type="text" name="newCouncilPosition" id="newCouncilPosition" class="form-control" placeholder="New Position Name" autofocus="autofocus">
                <label for="newCouncilPosition">New Position Name</label>
            </div>
            </div>
            </div>
            </div> <!-- end of position field -->
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
            <button type="button" class="btn btn-primary" id="saveCouncilChange"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save changes</button>
        </div>
        </div>
    </div>
    </div>
        <!-- Delete Modal -->
     <div class="modal fade" id="deleteCouncilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
           <h5 class="text-center">Are you sure you want to delete it?</h5>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
 Cancel</button>
            <button type="button" class="btn btn-primary"  id="saveCouncilDelete"><i class="fa fa-check" aria-hidden="true"></i>
 Yes</button>
        </div>
        </div>
    </div>
    </div>
    </div>





     <!-- Edit Modal -->
     <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="exampleModalLongTitle"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
        Edit Political Party</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
            </button>
        </div>
        <div class="modal-body">
            <form action="" method="post">
            <!-- polictical party field -->
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
            <div class="form-label-group">
                <input type="text" name="newPoliticalParty" id="newPoliticalParty" class="form-control" placeholder="New Political Pary Name" autofocus="autofocus">
                <label for="newPoliticalParty">New Political Party Name</label>
            </div>
            </div>
            </div>
            </div> <!-- end of politacl party field -->
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
 Cancel</button>
            <button type="button" class="btn btn-primary"  id="saveChange"><i class="fa fa-floppy-o" aria-hidden="true"></i>
 Save changes</button>
        </div>
        </div>
    </div>
    </div>

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
           <h5 class="text-center">Are you sure you want to delete it?</h5>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
 Cancel</button>
            <button type="button" class="btn btn-primary"  id="saveDelete"><i class="fa fa-check" aria-hidden="true"></i>
 Yes</button>
        </div>
        </div>
    </div>
    </div>
    </div>
    <div class="container">
    <div class="row">
    <div class="col">
     
    <section id="tabs" class="project-tab">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist" >
                                <a class="nav-item nav-link active text-white" id="nav-oarty-tab" data-toggle="tab" href="#nav-party" role="tab" aria-controls="nav-party" aria-selected="true">Political Party</a>
                                <a class="nav-item nav-link text-white" id="nav-position-tab" data-toggle="tab" href="#nav-position" role="tab" aria-controls="nav-position" aria-selected="false">Local Council Positions</a>
                                <a class="nav-item nav-link text-white" id="nav-council-tab" data-toggle="tab" href="#nav-council" role="tab" aria-controls="nav-council" aria-selected="false">Student Council Positions</a>
                                <a class="nav-item nav-link text-white" id="nav-council-som-tab" data-toggle="tab" href="#nav-council-som" role="tab" aria-controls="nav-council-som" aria-selected="false">SOM Student Council Positions</a>

                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active text-white" id="nav-party" role="tabpanel" aria-labelledby="nav-party-tab">
                            <table id="partyTB" class="table table-bordered text-white" >
                            <thead>
                            <tr>
                              <th>Code</th>
                              <th>Political Party</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php foreach($party as $poliParty) :  ?>
                          <tr>
                                <td><?= $poliParty['code']; ?></td>
                                <td><?= $poliParty['party_name']; ?></td>
                                <td></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            </table>
                            </div>
                            <div class="tab-pane fade" id="nav-position" role="tabpanel" aria-labelledby="nav-position-tab">
                            <table id="positionTB" class="table table-bordered">
                                  <thead>
                                  <tr>
                                    <th>Code</th>
                                    <th>Position</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php foreach($positions as $position) :  ?>
                                <tr>
                                      <td><?= $position['code']; ?></td>
                                      <td><?= $position['position_name']; ?></td>
                                      <td></td>
                                      </tr>
                                  <?php endforeach; ?>
                                  </tbody>
                                  </table>
                            </div>


                            <div class="tab-pane fade text-white" id="nav-council" role="tabpanel" aria-labelledby="nav-council-tab">
                            <table id="councilTB" class="table table-bordered">
                                  <thead>
                                  <tr>
                                    <th>Code</th>
                                    <th>Position</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                <?php foreach($councils as $position) :  ?>
                                <tr>
                                      <td><?= $position['code']; ?></td>
                                      <td><?= $position['position_name']; ?></td>
                                      <td></td>
                                      </tr>
                                  <?php endforeach; ?>
                                  </tbody>
                                  </table>
                            </div>
                            <div class="tab-pane fade text-white" id="nav-council-som" role="tabpanel" aria-labelledby="nav-council-som-tab">
                                <table id="somcouncilTB" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Position</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($somcouncils as $position) :  ?>
                                        <tr>
                                            <td><?= $position['code']; ?></td>
                                            <td><?= $position['position_name']; ?></td>
                                            <td></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div> <!-- end of table -->
    <div>
    </div>
    </div>
    </div> <!-- end of table -->
    <div>
    </div>
    </div>
  </div>
  </div>
  </div>  <!-- end of row -->
   
        <!-- /.container-fluid -->

        
      </div>
      <!-- /.content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    
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

     <!-- add Modal-->
     <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Party</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
            </button>
          </div>
          <div class="modal-body">
          <div style="background:#CC6464; color:white" class="card-header"><i class="fas fa-object-group"></i> Add Political Party</div>
          <div class="card-body">
         <div  id="addPoliticalPartyForm">
            <!-- political party field -->
            <div class="form-group">
            <div class="form-row">
            <div class="col-md-12">
            <div class="form-label-group">
                <input type="text" name="politicalParty" id="politicalParty" class="form-control" placeholder="Political Party Name">
                <label for="politicalParty">Political Party Name</label>
                <span id = "errorPoliticalParty"style ="color:red;"></span>
            </div>
            </div>
            </div>
            </div> <!-- end of political party field -->
          </div> <!-- end of form -->
          </div>
          <div class="modal-footer">
            <button id="add" class="btn btn-block" name="submit" type="submit"><i class="fa fa-plus" aria-hidden="true"></i>
 Submit</button>
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

    <!-- sweet alert dialog -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

     <!-- date picker cdn -->
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

     <!-- loading preloader -->
     <script src="../js/pace.js"></script>


     <!-- sweet alert dialog -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
     <script src="../js/toastr.js"></script>
     <script src="../js/time.js"></script>




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


<!-- add event -->
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
        $("#add").click(function (event) {
            var politicalParty = $("#politicalParty").val();
        { 
          if(politicalParty == ""){
              toastr.warning("Please fill in all fields");

          }else{
            $.ajax({
            type: "POST",
            url: "../operations/insert_party.php",
            data: {politicalParty,politicalParty},
            dataType:'text',
            success:function(data){
                Swal.fire({
                title: 'Success',
                text: "Data saved successfully!",
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
            
            }
        });
    });
});
 </script>

<!-- add campus position event -->
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
        $("#addCampusPosition").click(function (event) {
            var position = $("#councilPosition").val();

        {
          if(position == ""){
            toastr.warning("Please fill in all fields");

          }else{
            $.ajax({
            type: "POST",
            url: "../operations/insert_council_position.php",
            data: {councilPosition:position},
            dataType:'text',
            success:function(data){
                Swal.fire({
                title: 'Success',
                text: "Data saved successfully!",
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

           
            }
        });
    });
     $(function () {
         $("#addSOMCampusPosition").click(function (event) {
             var position = $("#somcouncilPosition").val();

             {
                 if(position == ""){
                     toastr.warning("Please fill in all fields");

                 }else{
                     $.ajax({
                         type: "POST",
                         url: "../operations/insert_som_council_position.php",
                         data: {councilPosition:position},
                         dataType:'text',
                         success:function(data){
                             Swal.fire({
                                 title: 'Success',
                                 text: "Data saved successfully!",
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


             }
         });
     });
});
 </script>





 <!-- add position event -->
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
        $("#addPosition").click(function (event) {
            var position = $("#position").val();
        {
          if(position == ""){
            toastr.warning("Please fill in all fields");
          }else{
            $.ajax({
            type: "POST",
            url: "../operations/insert_position.php",
            data: {position:position},
            dataType:'text',
            success:function(data){
                Swal.fire({
                title: 'Success',
                text: "Data saved successfully!",
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

           
            }
        });
    });
});
 </script>


<!-- update event -->
<script>
 $(document).ready(function() {
    var table = $('#partyTB').DataTable( {
        "columnDefs": [ {
            "targets": -1,
            "data": null,
            "defaultContent": "<button class='btn btn-success text-white' data-toggle='modal' data-target='#editModal'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> Edit</button> <button class='btn btn-danger' id='delete' data-toggle='modal' data-target='#deleteModal'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</button>"
        } ]
    } );
 
    $('#partyTB tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        $("#newPoliticalParty").val(data[1]);

        $(function () {
        $("#saveChange").click(function (event) {
            var newParty = $("#newPoliticalParty").val();
            var id = data[0];
        {
            $.ajax({
            type: "POST",
            url: "../operations/edit_party.php",
            data: {newPoliticalParty:newParty,id:id},
            dataType:'text',
            success:function(data){
                Swal.fire({
                title: 'Success',
                text: "Data updated successfully!",
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
        $("#saveDelete").click(function (event) {
            var politicalParty = data[1];
            var id = data[0];
        {
            $.ajax({
            type: "POST",
            url: "../operations/delete_party.php",
            data: {politicalParty:politicalParty,id:id},
            dataType:'text',
            success:function(data){
                Swal.fire({
                title: 'Success',
                text: "Data deleted successfully!",
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
    
});
 </script>

<!-- update council position event -->
<script>
 $(document).ready(function() {
    var table = $('#councilTB').DataTable( {
        "columnDefs": [ {
            "targets": -1,
            "data": null,
            "defaultContent": "<button class='btn btn-success text-white' data-toggle='modal' data-target='#editCouncilModal'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> Edit</button> <button class='btn btn-danger' id='deleteCouncil' data-toggle='modal' data-target='#deleteCouncilModal'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</button>"
        } ]
    } );
 
    $('#councilTB tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        $("#newCouncilPosition").val(data[1]);

        $(function () {
        $("#saveCouncilChange").click(function (event) {
            var newCouncilPosition = $("#newCouncilPosition").val();
            var id = data[0];
        {
            $.ajax({
            type: "POST",
            url: "../operations/edit_council_position.php",
            data: {newCouncilPosition:newCouncilPosition,id:id},
            dataType:'text',
            success:function(data){
                Swal.fire({
                title: 'Success',
                text: "Data saved successfully!",
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
        $("#saveCouncilDelete").click(function (event) {
            var position = data[1];
            var id = data[0];
        {
            $.ajax({
            type: "POST",
            url: "../operations/delete_council_position.php",
            data: {position:position,id:id},
            dataType:'text',
            success:function(data){
                Swal.fire({
                title: 'Success',
                text: "Data deleted successfully!",
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
    
});
 </script>

         <!-- som council position event -->

         <script>
             $(document).ready(function() {
                 var table = $('#somcouncilTB').DataTable( {
                     "columnDefs": [ {
                         "targets": -1,
                         "data": null,
                         "defaultContent": "<button class='btn btn-success text-white' data-toggle='modal' data-target='#editCouncilModal'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> Edit</button> <button class='btn btn-danger' id='deleteCouncil' data-toggle='modal' data-target='#deleteCouncilModal'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</button>"
                     } ]
                 } );

                 $('#somcouncilTB tbody').on( 'click', 'button', function () {
                     var data = table.row( $(this).parents('tr') ).data();
                     $("#newCouncilPosition").val(data[1]);

                     $(function () {
                         $("#saveCouncilChange").click(function (event) {
                             var newCouncilPosition = $("#newCouncilPosition").val();
                             var id = data[0];
                             {
                                 $.ajax({
                                     type: "POST",
                                     url: "../operations/edit_som_council_position.php",
                                     data: {newCouncilPosition:newCouncilPosition,id:id},
                                     dataType:'text',
                                     success:function(data){
                                         Swal.fire({
                                             title: 'Success',
                                             text: "Data saved successfully!",
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
                         $("#saveCouncilDelete").click(function (event) {
                             var position = data[1];
                             var id = data[0];
                             {
                                 $.ajax({
                                     type: "POST",
                                     url: "../operations/delete_som_council_position.php",
                                     data: {position:position,id:id},
                                     dataType:'text',
                                     success:function(data){
                                         Swal.fire({
                                             title: 'Success',
                                             text: "Data deleted successfully!",
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

             });
         </script>



<!-- update position event -->
<script>
 $(document).ready(function() {
    var table = $('#positionTB').DataTable( {
        "columnDefs": [ {
            "targets": -1,
            "data": null,
            "defaultContent": "<button class='btn btn-success text-white' data-toggle='modal' data-target='#editPositionModal'> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> Edit</button> <button class='btn btn-danger' id='deletePosition' data-toggle='modal' data-target='#deletePositionModal'> <i class='fa fa-trash' aria-hidden='true'></i> Delete</button>"
        } ]
    } );
 
    $('#positionTB tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        $("#newPosition").val(data[1]);

        $(function () {
        $("#savePositionChange").click(function (event) {
            var newPosition = $("#newPosition").val();
            var id = data[0];
        {
            $.ajax({
            type: "POST",
            url: "../operations/edit_position.php",
            data: {newPosition:newPosition,id:id},
            dataType:'text',
            success:function(data){
                Swal.fire({
                title: 'Success',
                text: "Data saved successfully!",
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
        $("#savePositionDelete").click(function (event) {
            var position = data[1];
            var id = data[0];
        {
            $.ajax({
            type: "POST",
            url: "../operations/delete_position.php",
            data: {position:position,id:id},
            dataType:'text',
            success:function(data){
                Swal.fire({
                title: 'Success',
                text: "Data deleted successfully!",
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
 
</body>

</html>
