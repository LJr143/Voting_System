<?php
  session_start();

    if(isset($_SESSION['saved'])){
      header('location:voting/VotingStudentCouncil.php');
    }
    if(!isset($_SESSION["OTP"])){
        header('location:../index.php');
    }
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>USeP E-Voting | Login</title>
  <link rel="icon" href="../img/usep_logo.png" />

  <!-- Bootstrap core CSS-->
  <link href="../bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet" />

  <!-- font awesome cdn -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet"
    type="text/css" />

  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../css/slider.css" />
  <link rel="stylesheet" href="../css/login.css" />
  <link rel="stylesheet" href="../css/toastr.css" />
    <link rel="stylesheet" href="../headerStyle.css">

  <style>
    .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
      background-color: #a24d4d !important;
    }

    body {
      /* Full height */
      height: 100%;

      /* Center and scale the image nicely */
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }
    body {
      margin-bottom: 100px;
    }
  </style>
</head>

<body>
<div class="header container-fluid d-flex justify-content-center">
    <div class="_head  d-flex text-white">
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

  <div class="container">
    <div class="card card-login mx-auto mt-5 shadow p-3 mb-5 bg-white rounded">
      <img src="../img/login_bkg.jpg" width="100%" alt="" />
      <div class="card-header text-center">
        Log In Successfully, Your Code Was Sent To Your Email:
        <b id="email"><?php echo $_SESSION["Uemail"] ?></b>
      </div>
      <div class="card-body">
        <div class="form-group">
          <div class="form-label-group">
            <input type="password" id="Code" class="form-control" placeholder="Code" required="required" />
            <label for="Code">Code</label>
          </div>
        </div>
        <div class="form-group">
          <div class="row justify-content-between">
            <div class="col-6">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="customControlInline" name="remember"
                  onclick="showPassword()" />
                <label class="custom-control-label" for="customControlInline">Show Code<menu type="context"></menu>
                </label>
              </div>
            </div>
            <div class="col-6">
              <button id="resend" class="btn btn-link">
                Resend Code
              </button>
            </div>
          </div>
        </div>
      </div>
      <button id="submit" class="btn btn-primary btn-block">
        <i class="fa fa-sign-in" aria-hidden="true"></i> Submit
      </button>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="../jquery/jquery-3.6.0.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <!--<script src="vendor/jquery-easing/jquery.easing.min.js"></script>-->

  <!-- sweet alert dialog -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
  </script>

  <script src="../js/long-press-event-min.js"></script>
  <script src="../js/toastr.js"></script>


  <!-- animate css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />

  <script>
    $(document).ready(function () {
      
      var count = 30;
      var counter = setInterval(timer, 1000);

      function timer() {
        count = count - 1;
        if (count <= 0) {
          $("#resend").prop( "disabled", false );
          $("#resend").html("Resend Code");
          clearInterval(counter);
          return;
        }
        $("#resend").prop( "disabled", true );
        $("#resend").html(count + "s Resend Code");
      }
      $(function () {
        $("#resend").click(function (event) {
          $.ajax({
            type: "POST",
            url: "../voting-operations/AjaxLogin.php",
            data: {
              resend: "resend"
            },
            dataType: 'json',
            success: function (response) {
              count = 30;

              counter = setInterval(timer, 1000);

              count = count - 1;
              if (count <= 0) {
                $("#resend").prop( "disabled", false );
                $("#resend").html("Resend Code");
                clearInterval(counter);
                return;
              }
              $("#resend").prop( "disabled", true );
              $("#resend").html(count + "s Resend Code");
            },
            error: function (ts) {
              Swal.fire({
                title: 'Login Failed!',
                text: "Problem In Accessing Your Account!",
                icon: 'error',
                confirmButtonColor: '#A24D4D',
                confirmButtonText: 'Try Again!'
              }).then((result) => {
                if (result.value) {
                  location.reload();
                }
              })
            }
          });
        });
      });

      $("#submit").click(function (event) {
        var code = $("#Code").val();
         $("#submit").prop( "disabled", true );
        $.ajax({
          type: "POST",
          url: "../voting-operations/AjaxOTP.php",
          data: {
            otp: code
          },
          cache: false,
          dataType: "json",
          success: function (OTP) {
            $("#submit").prop( "disabled", false );
            if (OTP[0] == "success") {
              if (OTP[1] == "SSG") {
                window.location.href = "VotingSSG.php";
              } else {
                window.location.href = "VotingStudentCouncil.php";
              }
            } else if (OTP[0] == "failed") {
              Swal.fire(
                "Incorrect Code!",
                "Check Your Email For The Code"
              );
              $("#Code").val('');
            } else {
              Swal.fire(
                "Unable To Create One-Time Password!",
                "Check Your Email For The Code"
              );
            }
          },
          error: function (ts) {
            Swal.fire({
              title: 'Login Failed!',
              text: "Problem In Accessing Your Account!",
              icon: 'error',
              confirmButtonColor: '#A24D4D',
              confirmButtonText: 'Try Again!'
            }).then((result) => {
              if (result.value) {
                location.reload();
              }
            })
          }
        });
      });
    });
      function showPassword() {
        var x = document.getElementById("Code");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      }
    
  </script>
</body>

</html>