<?php
    session_start();
    include '../config/db_config.php';
    include '../voting-operations/Student_Council/CandidateCarousel.php';
    include '../voting-operations/Decryption.php';
    error_reporting(0);
    $connect = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

   if(isset($_SESSION["saved"])){

}else{
     header('location:../index.php');
    }
    
    $campus;
    $college;  
    $program;
    $year;

    $voter = mysqli_real_escape_string($connect,decryption($_SESSION["saved"]));
    $campus = mysqli_real_escape_string($connect,decryption($_SESSION["Usep-Comelec"]));
  
    //Get The User Data
    $query = 'select * from vw_voter where stud_id="'.$voter.'" AND campus="'.$campus.'"';
    $result = mysqli_query($connect,$query);
    $resultChecke = mysqli_num_rows($result);

    if($resultChecke > 0){
      while($row = mysqli_fetch_assoc($result)){
        $campus = $row['campus'];
        $college = $row['college'];
        $program = $row['program'];
        $year = $row['year'];
      }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>USeP E-Voting | Voting</title>
  <link rel="icon" href="../img/usep_logo.png">

  <!-- Bootstrap CSS -->
  <link href="../bootstrap-4.3.1-dist/css/bootstrap.css" rel="stylesheet" />

  <!-- Font-Awesome CSS -->
  <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css" />

  <!--My Design -->
  <link href="../css/Main.css" rel="stylesheet" />

  <script src="../jquery/jquery-3.6.0.min.js"></script>
  <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

  <!--flipster Carousel -->
  <link rel="stylesheet" href="../jquery-flipster-carousel/dist/jquery.flipster.min.css">

  <!-- Custom fonts for this template-->
  <script src="../fontawesome-6.0.0/js/all.min.js"></script>

  <style>
    body {
      background-color: #f6f9fb;
    }

    .styles_Card {
      border-radius: 16px;
      border: 1px solid;
      background-color: #fff;
      border-color: #d1dadf;
      text-decoration: none;
      padding: 20px 20px;
      margin: 0 0 0 0;
    }

    #img {
      height: 100px;
      width: 100px
    }

    .crop {
      height: 200px;
      width: 200px;
      overflow: hidden;
    }

    .crop img {
      width: 200px;
      height: 200px;
      clip: rect(0px, 200px, 200px, 0px);
    }

    .ChooseYourCandidate {
      overflow: hidden;
    }

    #NoVote img {
      width: 200px;
      height: 200px
    }

    #NoVote .crop {
      height: 100%;
      width: 100%;
      overflow: hidden
    }
    .text-responsive {
      font-size: calc(100% + 1vw + 1vh);
    }
    #cover-spin {
    position:fixed;
    width:100%;
    left:0;right:0;top:0;bottom:0;
    background-color: rgba(255,255,255,0.7);
    z-index:9999;
    display:none;
    }

    @-webkit-keyframes spin {
      from {-webkit-transform:rotate(0deg);}
      to {-webkit-transform:rotate(360deg);}
    }

    @keyframes spin {
      from {transform:rotate(0deg);}
      to {transform:rotate(360deg);}
    }

    #cover-spin::after {
        content:'';
        display:block;
        position:absolute;
        left:48%;top:40%;
        width:80px;height:80px;
        border-style:solid;
        border-color:black;
        border-top-color:transparent;
        border-width: 4px;
        border-radius:50%;
        -webkit-animation: spin .8s linear infinite;
        animation: spin .8s linear infinite;
    }
  </style>
</head>

<body class="jumbotron m-0 p-0" onbeforeunload="HandleBackFunctionality()">
<div id="cover-spin"></div>
  <div class="container-fluid">
    <div class="row">
      <div class="text-center w-100 col-12">
        <img class="rounded-circle mt-1" id="img">
        <h1 class="text-responsive font-weight-bold text-uppercase text-dark">
          <?PHP echo $campus ?> CAMPUS STUDENT COUNCIL</h1>
      </div>
      <?php echo Make_Query_For_Position($connect,$campus);?>
      <div class="mx-3">
        <div class="form-row">
          <?php echo Make_Slides_For_Student_Council($connect,$campus,$college,$program,$year);?>
        </div>
      </div>
    </div>
  </div>
</body>

</html>

<!-- sweet alert dialog -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="../jquery-flipster-carousel/dist/jquery.flipster.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
  integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

<script>
  function hide() {
    document.getElementById("submit").style.visibility = 'hidden';
  }
  //Remove the data from tbloginlogs
  window.onbeforeunload = function () {
    $.ajax({
      type: "POST",
      url: "../voting-operations/AjaxClose.php",
      data: {
        voter: "<?php echo $_SESSION["saved"]?>",
        campus: "<?php echo $_SESSION["Usep-Comelec"] ?>",
        mode: "Student",
        all: "true"
      }
    });
  }
  $(document).ready(function () {
    $('#cover-spin').show();
    //Logo In Every Campus
    var campus = "<?php echo $campus ?>";
     if (campus == "Mabini") {
      $("#img").attr("src", "../img/campus_logos/mabini_logo.png");
    } else if (campus == "Tagum") {
      $("#img").attr("src", "../img/campus_logos/tagum_logo.png");
    }
    //Checks In Before Displaying In The Page Carousel
    $.ajax({
      type: "POST",
      url: "../voting-operations/Student_Council/AjaxDisplay.php",
      data: {
        voter : "<?php echo $_SESSION["saved"]?>",
        campus : "<?php echo $_SESSION["Usep-Comelec"] ?>"
      },
      dataType: 'json',
      success: function (response) {
        if (response[3] == "Session") {
          $("#ChooseYourCandidate1").remove();
          $("#flip-items1").removeClass("position-absolute");

          $("#ChooseYourCandidate2").remove();
          $("#flip-items2").removeClass("position-absolute");

          $("#ChooseYourCandidate3").remove();
          $("#flip-items3").removeClass("position-absolute");

          $("#ChooseYourCandidate4").remove();
          $("#flip-items4").removeClass("position-absolute");

          $("#ChooseYourCandidate5").remove();
          $("#flip-items5").removeClass("position-absolute");

          $("#ChooseYourCandidate6").remove();
          $("#flip-items6").removeClass("position-absolute");

          $("#ChooseYourCandidate7").remove();
          $("#flip-items7").removeClass("position-absolute");

          $("#ChooseYourCandidate8").remove();
          $("#flip-items8").removeClass("position-absolute");

          $("#ChooseYourCandidate9").remove();
          $("#flip-items9").removeClass("position-absolute");

          $("#ChooseYourCandidate10").remove();
          $("#flip-items10").removeClass("position-absolute");
        }
        display(response[0][0], response[0][1], response[0][2], response[0][3], response[0][4], response[0][5], response[0][6], response[0][7], response[0][8], response[0][9], response[1][0], response[1][1], response[1][2], response[1][3], response[1][4], response[1][5], response[1][6], response[1][7], response[1][8], response[1][9], response[2][0], response[2][1], response[2][2], response[2][3], response[2][4], response[2][5], response[2][6], response[2][7], response[2][8], response[2][9]);
        $('#cover-spin').hide();
      },
      error: function (ts) {
        Swal.fire({
          title: 'Database Error!',
          text: "Problem In Accessing The Database Restart Your Device!",
          icon: 'error',
          confirmButtonColor: '#A24D4D',
          confirmButtonText: 'Okay'
        }).then((result) => {
          if (result.value) {
            location.reload();
          }
        })
      }
    });
  });

  function display(I1, I2, I3, I4, I5, I6, I7, I8, I9, I10, S1, S2, S3, S4, S5, S6, S7, S8, S9, S10, F1, F2, F3, F4, F5,
    F6, F7, F8, F9, F10) {
    var Id1 = parseInt(I1);
    var Id2 = parseInt(I2);
    var Id3 = parseInt(I3);
    var Id4 = parseInt(I4);
    var Id5 = parseInt(I5);
    var Id6 = parseInt(I6);
    var Id7 = parseInt(I7);
    var Id8 = parseInt(I8);
    var Id9 = parseInt(I9);
    var Id10 = parseInt(I10);

    var Start1 = parseInt(S1);
    var Start2 = parseInt(S2);
    var Start3 = parseInt(S3);
    var Start4 = parseInt(S4);
    var Start5 = parseInt(S5);
    var Start6 = parseInt(S6);
    var Start7 = parseInt(S7);
    var Start8 = parseInt(S8);
    var Start9 = parseInt(S9);
    var Start10 = parseInt(S10);

    var Flag1 = String(F1);
    var Flag2 = String(F2);
    var Flag3 = String(F3);
    var Flag4 = String(F4);
    var Flag5 = String(F5);
    var Flag6 = String(F6);
    var Flag7 = String(F7);
    var Flag8 = String(F8);
    var Flag9 = String(F9);
    var Flag10 = String(F10);

    $("#Carousel1").flipster({
      style: 'carousel',
      spacing: -0.5,
      buttons: true,
      itemcontainer: 'ul',
      itemselector: 'li',
      enableTouch: true,
      start: Start1,
      loop: true,
      click: true,
      onItemSwitch: function (currentItem, previousItem) {
        Id1 = $(currentItem).data('id');
        Start1 = $(currentItem).data('start');
        $("#ChooseYourCandidate1").remove();
        $("#flip-items1").removeClass("position-absolute");
        Flag1 = false;
      },
    });
    $("#Carousel2").flipster({
      style: 'carousel',
      spacing: -0.5,
      buttons: true,
      itemcontainer: 'ul',
      itemselector: 'li',
      enableTouch: true,
      start: Start2,
      loop: true,
      click: true,
      onItemSwitch: function (currentItem) {
        Id2 = $(currentItem).data('id');
        Start2 = $(currentItem).data('start');
        $("#ChooseYourCandidate2").remove();
        $("#flip-items2").removeClass("position-absolute");
        Flag2 = false;
      },
    });
    $("#Carousel3").flipster({
      style: 'carousel',
      spacing: -0.5,
      buttons: true,
      itemcontainer: 'ul',
      itemselector: 'li',
      enableTouch: true,
      start: Start3,
      loop: true,
      click: true,
      onItemSwitch: function (currentItem) {
        Id3 = $(currentItem).data('id');
        Start3 = $(currentItem).data('start');
        $("#ChooseYourCandidate3").remove();
        $("#flip-items3").removeClass("position-absolute");
        Flag3 = false;
      },
    });
    $("#Carousel4").flipster({
      style: 'carousel',
      spacing: -0.5,
      buttons: true,
      itemcontainer: 'ul',
      itemselector: 'li',
      enableTouch: true,
      start: Start4,
      loop: true,
      click: true,
      onItemSwitch: function (currentItem) {
        Id4 = $(currentItem).data('id');
        Start4 = $(currentItem).data('start');
        $("#ChooseYourCandidate4").remove();
        $("#flip-items4").removeClass("position-absolute");
        Flag4 = false;
      },
    });
    $("#Carousel5").flipster({
      style: 'carousel',
      spacing: -0.5,
      buttons: true,
      itemcontainer: 'ul',
      itemselector: 'li',
      enableTouch: true,
      start: Start5,
      loop: true,
      click: true,
      onItemSwitch: function (currentItem) {
        Id5 = $(currentItem).data('id');
        Start5 = $(currentItem).data('start');
        $("#ChooseYourCandidate5").remove();
        $("#flip-items5").removeClass("position-absolute");
        Flag5 = false;
      },
    });
    $("#Carousel6").flipster({
      style: 'carousel',
      spacing: -0.5,
      buttons: true,
      itemcontainer: 'ul',
      itemselector: 'li',
      enableTouch: true,
      start: Start6,
      loop: true,
      click: true,
      onItemSwitch: function (currentItem) {
        Id6 = $(currentItem).data('id');
        Start6 = $(currentItem).data('start');
        $("#ChooseYourCandidate6").remove();
        $("#flip-items6").removeClass("position-absolute");
        Flag6 = false;
      },
    });
    $("#Carousel7").flipster({
      style: 'carousel',
      spacing: -0.5,
      buttons: true,
      itemcontainer: 'ul',
      itemselector: 'li',
      enableTouch: true,
      start: Start7,
      loop: true,
      click: true,
      onItemSwitch: function (currentItem) {
        Id7 = $(currentItem).data('id');
        Start7 = $(currentItem).data('start');
        $("#ChooseYourCandidate7").remove();
        $("#flip-items7").removeClass("position-absolute");
        Flag7 = false;
      },
    });
    $("#Carousel8").flipster({
      style: 'carousel',
      spacing: -0.5,
      buttons: true,
      itemcontainer: 'ul',
      itemselector: 'li',
      enableTouch: true,
      start: Start8,
      loop: true,
      click: true,
      onItemSwitch: function (currentItem) {
        Id8 = $(currentItem).data('id');
        Start8 = $(currentItem).data('start');
        $("#ChooseYourCandidate8").remove();
        $("#flip-items8").removeClass("position-absolute");
        Flag8 = false;
      },
    });
    $("#Carousel9").flipster({
      style: 'carousel',
      spacing: -0.5,
      buttons: true,
      itemcontainer: 'ul',
      itemselector: 'li',
      enableTouch: true,
      start: Start9,
      loop: true,
      click: true,
      onItemSwitch: function (currentItem) {
        Id9 = $(currentItem).data('id');
        Start9 = $(currentItem).data('start');
        $("#ChooseYourCandidate9").remove();
        $("#flip-items9").removeClass("position-absolute");
        Flag9 = false;
      },
    });
    $("#Carousel10").flipster({
      style: 'carousel',
      spacing: -0.5,
      buttons: true,
      itemcontainer: 'ul',
      itemselector: 'li',
      enableTouch: true,
      start: Start10,
      loop: true,
      click: true,
      onItemSwitch: function (currentItem) {
        Id10 = $(currentItem).data('id');
        Start10 = $(currentItem).data('start');
        $("#ChooseYourCandidate10").remove();
        $("#flip-items10").removeClass("position-absolute");
        Flag10 = false;
      },
    });

    $("#submit").click(function (event) {
      if (Flag1 === "true" || Flag2 === "true" || Flag3 === "true" || Flag4 === "true" || Flag5 === "true" ||
        Flag6 === "true" || Flag7 === "true" || Flag8 === "true" || Flag9 === "true" || Flag10 === "true") {
        Swal.fire({
          title: 'Please Choose Your Candidate',
          icon: 'error',
          showCancelButton: false,
          confirmButtonText: 'Okay'
        })
      } else {
        Swal.fire({
          title: 'Do you want Proceed to College Local Council?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#1ba205',
          cancelButtonColor: '#A24D4D',
          confirmButtonText: 'Yes, Proceed To The Next Step.'
        }).then((result) => {
          if (result.value) {
            $.ajax({
              type: "POST",
              url: "../voting-operations/Student_Council/AjaxSession.php",
              data: {
                'campus': "<?php echo $_SESSION["Usep-Comelec"] ?>",
                'ID1': Id1,
                'ID2': Id2,
                'ID3': Id3,
                'ID4': Id4,
                'ID5': Id5,
                'ID6': Id6,
                'ID7': Id7,
                'ID8': Id8,
                'ID9': Id9,
                'ID10': Id10,

                'ST1': Start1,
                'ST2': Start2,
                'ST3': Start3,
                'ST4': Start4,
                'ST5': Start5,
                'ST6': Start6,
                'ST7': Start7,
                'ST8': Start8,
                'ST9': Start9,
                'ST10': Start10
              },
              success: function (hays) {
                window.location = 'VotingLocalCouncil.php';
              },
              error: function (ts) {
                Swal.fire({
                  title: 'Database Error!',
                  text: "Problem In Accessing The Database Restart Your Device!",
                  icon: 'error',
                  confirmButtonColor: '#A24D4D',
                  confirmButtonText: 'Okay'
                }).then((result) => {
                  if (result.value) {
                    location.reload();
                  }
                })
              }
            });
          }
        });
      }
    });
    $(function () {
      $("#vote").click(function (event) {
        if (Flag1 === "true" || Flag2 === "true" || Flag3 === "true" || Flag4 === "true" || Flag5 === "true" ||
          Flag6 === "true" || Flag7 === "true" || Flag8 === "true" || Flag9 === "true" || Flag10 === "true") {
          Swal.fire({
            title: 'Please Choose Your Candidate',
            icon: 'error',
            showCancelButton: false,
            confirmButtonText: 'Okay'
          });
        } else {
          Swal.fire({
            title: 'Do you want to submit your vote?',
            text: "You won't be able to revert this.",
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#1ba205',
            cancelButtonColor: '#A24D4D',
            confirmButtonText: 'Yes, Submit My Vote.',
            cancelButtonText: 'Back'
          }).then((result) => {
            if (result.value) {
              $.ajax({
                type: "POST",
                url: "../voting-operations/Student_Council/AjaxSubmit.php",
                data: {
                  'voter': "<?php echo $_SESSION["saved"] ?>",
                  'campus': "<?php echo $_SESSION["Usep-Comelec"] ?>",
                  'ID1': Id1,
                  'ID2': Id2,
                  'ID3': Id3,
                  'ID4': Id4,
                  'ID5': Id5,
                  'ID6': Id6,
                  'ID7': Id7,
                  'ID8': Id8,
                  'ID9': Id9,
                  'ID10': Id10
                },
                dataType: 'json',
                success: function (response) {
                  let timerInterval
                  Swal.fire({
                    title: 'Please wait!',
                    html: 'Submitting All Your Votes In <b></b> Seconds.',
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    onBeforeOpen: () => {
                      Swal.showLoading()
                      timerInterval = setInterval(() => {
                        const content = Swal.getContent()
                        if (content) {
                          const b = content.querySelector('b')
                          if (b) {
                            b.textContent = Swal.getTimerLeft()
                          }
                        }
                      }, 100)
                    },
                    onClose: () => {
                      clearInterval(timerInterval)
                    }
                  }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                      $.ajax({
                        type: "POST",
                        url: "../voting-operations/AjaxClose.php",
                        data: {
                            voter: "<?php echo $_SESSION["saved"]?>",
                            campus: "<?php echo $_SESSION["Usep-Comelec"] ?>",
                            mode: "Student"
                        },
                        success: function () {
                          if (response[0] == "Cast") {
                            window.location.href = 'VoteCast.php';
                          } else if (response[0] == "Proxy") {
                            window.location.href = 'VoteProxy.php';
                          } else {
                            window.location.href = 'VoteNotCast.php';
                          }
                        },
                        error: function (ts) {
                          Swal.fire({
                            title: 'Database Error!',
                            text: "Problem In Accessing The Database Restart Your Device!",
                            icon: 'error',
                            confirmButtonColor: '#A24D4D',
                            confirmButtonText: 'Okay'
                          }).then((result) => {
                            if (result.value) {
                              location.reload();
                            }
                          })
                        }
                      });
                    }
                  })
                },
                error: function (ts) {
                  Swal.fire({
                    title: 'Database Error!',
                    text: "Problem In Accessing The Database Restart Your Device!",
                    icon: 'error',
                    confirmButtonColor: '#A24D4D',
                    confirmButtonText: 'Okay'
                  }).then((result) => {
                    if (result.value) {
                      location.reload();
                    }
                  })
                }
              });
            } else {
              window.location = 'VotingStudentCouncil.php';
            }
          });
        }
      });
    });
  }
</script>