<?php

    session_start();
    include '../config/db_config.php';
    include '../voting-operations/Decryption.php';
    include '../voting-operations/SSG/CandidateCarouselSSG.php';

    $connect = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    if(isset($_SESSION["savedSSG"])){

    }else{
      header('location:../index.php');
    }
    
    $voter = mysqli_real_escape_string($connect,decryption($_SESSION["savedSSG"]));
    $campus = mysqli_real_escape_string($connect,decryption($_SESSION["Usep-Comelec"]));
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
    .container-fluid {
      margin-bottom: 100px;
    }
  </style>
</head>

<body class="jumbotron m-0 p-0" onbeforeunload="HandleBackFunctionality()">
  <div class="container-fluid">
    <div class="row">
      <div class="text-center w-100 col-12">
        <img class="rounded-circle mt-1" id="img" src="../img/SSG_Logo.png">
        <h1 class="text-responsive font-weight-bold text-uppercase text-dark">
          University Student Government
        </h1>
        <div class="form-group col-12">
          <div class="row">
            <?php echo Make_Slides_For_SSG($connect);?>
            <div class="col-lg-7 col-md-7 col-xs-6">

            </div>
            <div id="hide" class="col-lg-4 col-md-4 col-xs-5">
              <button id="vote" class="btn btn-success mb-1 text-center p-3">Submit Your Vote</button>
            </div>
            <div class="col-lg-1 col-md-1 col-xs-1">

            </div>
          </div>
        </div>
      </div>
    </div>
</body>

</html>

<!-- sweet alert dialog -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<!--flipster Carousel-->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="../jquery-flipster-carousel/dist/jquery.flipster.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
  integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  
<script>
  window.onbeforeunload = function () {
    $.ajax({
      type: "POST",
      url: "../voting-operations/AjaxClose.php",
      data: {
        voter: "<?php echo $_SESSION["savedSSG"]?>",
        campus: "<?php echo $_SESSION["Usep-Comelec"] ?>",
        mode: "SSG",
        all: "true"
      }
    });
  }

  $(document).ready(function () {
    var campus = "<?php echo $_SESSION["Usep-Comelec"] ?>";
    $.ajax({
      type: "POST",
      url: "../voting-operations/SSG/AjaxDisplaySSG.php",
      data: {
        campus: campus
      },
      dataType: 'json',
      success: function (response) {
        display(response[0][0], response[0][1], response[0][2], response[0][3], response[0][4], response[0][5], response[0][6], response[0][7], response[0][8], response[0][9]);
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

  function display(F1, F2, F3, F4, F5, F6, F7, F8, F9, F10) {
    var Id1 = null;
    var Id2 = null;
    var Id3 = null;
    var Id4 = null;
    var Id5 = null;
    var Id6 = null;
    var Id7 = null;
    var Id8 = null;
    var Id9 = null;
    var Id10 = null;

    var Start1 = 0;
    var Start2 = 0;
    var Start3 = 0;
    var Start4 = 0;
    var Start5 = 0;
    var Start6 = 0;
    var Start7 = 0;
    var Start8 = 0;
    var Start9 = 0;
    var Start10 = 0;

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

    $(function () {
      $("#vote").click(function (event) {
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
                url: "../voting-operations/SSG/AjaxSubmitSSG.php",
                data: {
                  'voter': "<?php echo $_SESSION["savedSSG"] ?>",
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
                            voter: "<?php echo $_SESSION["savedSSG"]?>",
                            campus: "<?php echo $_SESSION["Usep-Comelec"] ?>",
                            mode: "SSG"
                        },
                        success: function () {
                          if (response[0] == "Cast") {
                            window.location.href = 'VoteCast.php';
                          } else if (response[0] == "Proxy") {
                            window.location.href = 'VoteProxy.php';
                          } else {
                            window.location.href = 'VoteNotCast.php';
                          }
                        }
                      });
                    }
                  })
                },
                error: function (ts) {
                  console.log(ts);
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
              window.location = 'VotingSSG.php';
            }
          });
        }
      });
    });
  }
</script>