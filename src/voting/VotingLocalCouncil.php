<?php
    session_start();
    include '../config/db_config.php';
    include '../voting-operations/Decryption.php';
    include '../voting-operations/Local_Council/CandidateCarouselLocal.php';
    //error_reporting(0);

    $connect = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    if(isset($_SESSION["saved"])){

    }else{
      header('location:../index.php');
    }
    
    if(!isset($_SESSION["Proceed"])){
      header('location:VotingStudentCouncil.php');
    }


   $college;
    $program;
    $voter = mysqli_real_escape_string($connect,decryption($_SESSION["saved"]));
    $campus = mysqli_real_escape_string($connect,decryption($_SESSION["Usep-Comelec"]));

    //Getting The Data Of The Student From Database
    $query = 'select * from vw_voter where stud_id="'.$voter.'" AND campus="'.$campus.'"';
    $result = mysqli_query($connect,$query);
    $resultChecke = mysqli_num_rows($result);

    if($resultChecke > 0){
        while($row = mysqli_fetch_assoc($result)){
            $campus = $row['campus'];
            $college = $row['college_name'];
            $program = $row['college_program_name'];
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

    #summaryimg {
      max-width: 100%;
      height: auto;
    }

    #firsttitle {
      font-size: 18px;
      border-bottom: 1px solid black;
    }

    #secondtitle {
      font-size: 20px;
    }

    #back {
      background-color: #A24D4D
    }

    .crop {
      height: 200px;
      width: 200px;
      overflow: hidden
    }

    .crop img {
      width: 200px;
      height: 200px;
      clip: rect(0px, 200px, 200px, 0px);
    }

    .ChooseYourCandidate {
      overflow: hidden
    }

    #NoVote h2 {
      width: 200px;
      height: 200px
    }

    #NoVote .crop {
      height: 100%;
      width: 100%;
      overflow: hidden
    }

    @media (max-width: 768px) {
      #Summaryfont {
        font-size: 1.6em; // or any pixel value
      }

      #firsttitle {
        font-size: 14px;
        border-bottom: 1px solid black;
      }

      #secondtitle {
        font-size: 16px;
      }
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
  <title>USeP E-Voting</title>
</head>

<body class="jumbotron m-0 p-0">
  <!--<div id="cover-spin"></div>-->
  <div class="container-fluid">
    <div class="row">
      <div class="text-center w-100 col-12">
        <img class="rounded-circle mt-1" id="img">
        <h1 class="text-responsive font-weight-bold text-uppercase text-dark" id="local">
        </h1>
      </div>
      <?php echo Make_Query_For_Position($connect,$campus);?>
      <div class="mx-3">
        <div class="form-row">
          <?php echo Make_Slides_For_Local_Council($connect,$campus,$college,$program,$year);?>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal  -->
  <div class="modal fade bd-example-modal-lg" id="summary" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center justify-content-center">
          <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3 col-3">
              <img src="../img/usep_logo.png" class="rounded-circle" id="summaryimg">
            </div>
            <div class="col-lg-8 col-md-8 col-sm-6 col-6">
              <h6 class="text-center col-12 mt-2 p-1" id="firsttitle">UNIVERSITY OF SOUTHEASTERN PHILIPPINES</h6>
              <h6 class="text-center col-12 m-0 p-0" id="secondtitle">COMMISSION ON ELECTION</h6>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3 col-3">
              <img src="../img/COC Logo2.png" class="rounded-circle" id="summaryimg">
            </div>
          </div>
        </div>
        <div class="modal-body text-center">
          <h6 class="h2 col-12 mt-n2 p-0" id="Summaryfont">Summary Of Your Vote</h6>
          <div class="row">
            <div class="col-md-12 col-lg-6">
              <h6 class="h5 col-12 mt-3 p-0 text-uppercase">
                <?PHP ECHO $campus; ?> CAMPUS STUDENT COUNCIL</h6>
              <p id="1" class="lead text-uppercase"><p>
              <p id="2" class="lead text-uppercase"><p>
              <p id="3" class="lead text-uppercase"><p>
              <p id="4" class="lead text-uppercase"><p>
              <p id="5" class="lead text-uppercase"><p>
              <p id="6" class="lead text-uppercase"><p>
              <p id="7" class="lead text-uppercase"><p>
              <p id="8" class="lead text-uppercase"><p>
              <p id="9" class="lead text-uppercase"><p>
              <p id="10" class="lead text-uppercase"><p>
            </div>
            <div class="col-md-12 col-lg-6">
              <h6 class="h5 col-12 mt-3 p-0 text-uppercase" id="localmodal"></h6>
              <p id="Local1" class="lead text-uppercase"><p>
              <p id="Local2" class="lead text-uppercase"><p>
              <p id="Local3" class="lead text-uppercase"><p>
              <p id="Local4" class="lead text-uppercase"><p>
              <p id="Local5" class="lead text-uppercase"><p>
              <p id="Local6" class="lead text-uppercase"><p>
              <p id="Local7" class="lead text-uppercase"><p>
              <p id="Local8" class="lead text-uppercase"><p>
              <p id="Local9" class="lead text-uppercase"><p>
              <p id="Local10" class="lead text-uppercase"><p>
              <p id="Local11" class="lead text-uppercase"><p>
              <p id="Local12" class="lead text-uppercase"><p>
              <p id="Local13" class="lead text-uppercase"><p>
              <p id="Local14" class="lead text-uppercase"><p>
              <p id="Local15" class="lead text-uppercase"><p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="back" type="button" class="btn text-white px-4" data-dismiss="modal">Back</button>
          <button id="vote" type="button" class="btn btn-success px-4">Vote</button>
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
  var campus = "<?php echo $campus ?>";
  var college = "<?php echo $college ?>";
  var program = "<?php echo $program ?>";
  var lcname;

  window.onbeforeunload = function () {
    $.ajax({
      type: "POST",
      url: "../voting-operations/AjaxClose.php",
      data: {
        voter: "<?php echo $_SESSION["saved"]?>",
        campus: "<?php echo $_SESSION["Usep-Comelec"] ?>",
        mode: "Local",
        all: "true"
      }
    });
  }

  $(document).ready(function () {
    //$('#cover-spin').show();
    //Logo For LC
    var campus = "<?php echo $campus ?>";
   if (campus == "Mabini") {
      $("#img").attr("src", "../img/campus_logos/mabini_logo.png");
    } else if (campus == "Tagum") {
      $("#img").attr("src", "../img/campus_logos/tagum_logo.png");
    }

    //Heading Display
    if (campus == "Tagum") {
      if (program == "BS in Agricultural and Biosystems Engineering" || program ==
        "Bachelor of Science in Agricultural Engineering") {
        lcname = "Society of Agricultural and Biosystem Engineering Students";
      } else if (program == "Bachelor of Elementary Education" || program ==
        "Bachelor of Special Needs Education" || program == "Bachelor of Early Childhood Education") {
        lcname = "Organization of Future Elementary Educators";
      } else if (program == "BSEd" || program == "Bachelor of Technical-vocational Teacher Education") {
        lcname = "Association of Future Secondary Teachers";
      } else if (program == "Bachelor of Science in Information Technology") {
        lcname = "Society of Information and Technology Students";
      } else {
        lcname = program;
      }
    } else if (campus == "Mabini") {
      lcname = program;
    }else {

    }
    $('#local').html(lcname + ' local Council');
    $('#localmodal').html(lcname + ' local Council');

    //Display to the carousel
    $.ajax({
      type: "POST",
      url: "../voting-operations/Local_Council/AjaxDisplayLocal.php",
      data: {
        voter: "<?php echo $_SESSION["saved"] ?>",
        campus: "<?php echo $_SESSION["Usep-Comelec"] ?>"
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

          $("#ChooseYourCandidate11").remove();
          $("#flip-items11").removeClass("position-absolute");

          $("#ChooseYourCandidate12").remove();
          $("#flip-items12").removeClass("position-absolute");

          $("#ChooseYourCandidate13").remove();
          $("#flip-items13").removeClass("position-absolute");

          $("#ChooseYourCandidate14").remove();
          $("#flip-items14").removeClass("position-absolute");

          $("#ChooseYourCandidate15").remove();
          $("#flip-items15").removeClass("position-absolute");
        }
        display(response[0][0], response[0][1], response[0][2], response[0][3], response[0][4], response[0][5], response[0][6], response[0][7], response[0][8], response[0][9], response[0][10], response[0][11], response[0][12], response[0][13], response[0][14], response[1][0], response[1][1], response[1][2], response[1][3], response[1][4], response[1][5], response[1][6], response[1][7], response[1][8], response[1][9], response[1][10], response[1][11], response[1][12], response[1][13], response[1][14], response[2][0], response[2][1], response[2][2], response[2][3], response[2][4], response[2][5], response[2][6], response[2][7], response[2][8], response[2][9], response[2][10], response[2][11], response[2][12], response[2][13], response[2][14]);
        //$('#cover-spin').hide();
        console.log(response);
      },
      error: function (ts) {
        console.log(ts.responseText);
        Swal.fire({
          title: 'Database Error in AjaxDisplayLocal.php!',
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

    //Disable the back button
    (function (global) {

      if (typeof (global) === "undefined") {
        throw new Error("window is undefined");
      }

      var _hash = "!";
      var noBackPlease = function () {
        global.location.href += "#";

        // making sure we have the fruit available for juice....
        // 50 milliseconds for just once do not cost much (^__^)
        global.setTimeout(function () {
          global.location.href += "!";
        }, 50);
      };

      // Earlier we had setInerval here....
      global.onhashchange = function () {
        if (global.location.hash !== _hash) {
          global.location.hash = _hash;
        }
      };

      global.onload = function () {

        noBackPlease();

        // disables backspace on page except on input fields and textarea..
        document.body.onkeydown = function (e) {
          var elm = e.target.nodeName.toLowerCase();
          if (e.which === 8 && (elm !== 'input' && elm !== 'textarea')) {
            e.preventDefault();
          }
          // stopping event bubbling up the DOM tree..
          e.stopPropagation();
        };

      };

    })(window);
  });

  function display(I1, I2, I3, I4, I5, I6, I7, I8, I9, I10, I11, I12, I13, I14, I15, S1, S2, S3, S4, S5, S6, S7, S8, S9, S10,
    S11, S12, S13, S14, S15, F1, F2, F3, F4, F5, F6, F7, F8, F9, F10, F11, F12, F13, F14, F15) {
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
    var Id11 = parseInt(I11);
    var Id12 = parseInt(I12);
    var Id13 = parseInt(I13);
    var Id14 = parseInt(I14);
    var Id15 = parseInt(I15);

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
    var Start11 = parseInt(S11);
    var Start12 = parseInt(S12);
    var Start13 = parseInt(S13);
    var Start14 = parseInt(S14);
    var Start15 = parseInt(S15);

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
    var Flag11 = String(F11);
    var Flag12 = String(F12);
    var Flag13 = String(F13);
    var Flag14 = String(F14);
    var Flag15 = String(F15);

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
    $("#Carousel11").flipster({
      style: 'carousel',
      spacing: -0.5,
      buttons: true,
      itemcontainer: 'ul',
      itemselector: 'li',
      enableTouch: true,
      start: Start11,
      loop: true,
      click: true,
      onItemSwitch: function (currentItem) {
        Id11 = $(currentItem).data('id');
        Start11 = $(currentItem).data('start');
        $("#ChooseYourCandidate11").remove();
        $("#flip-items11").removeClass("position-absolute");
        Flag11 = false;
      },
    });
    $("#Carousel12").flipster({
      style: 'carousel',
      spacing: -0.5,
      buttons: true,
      itemcontainer: 'ul',
      itemselector: 'li',
      enableTouch: true,
      start: Start12,
      loop: true,
      click: true,
      onItemSwitch: function (currentItem) {
        Id12 = $(currentItem).data('id');
        Start12 = $(currentItem).data('start');
        $("#ChooseYourCandidate12").remove();
        $("#flip-items12").removeClass("position-absolute");
        Flag12 = false;
      },
    });
    $("#Carousel13").flipster({
      style: 'carousel',
      spacing: -0.5,
      buttons: true,
      itemcontainer: 'ul',
      itemselector: 'li',
      enableTouch: true,
      start: Start13,
      loop: true,
      click: true,
      onItemSwitch: function (currentItem) {
        Id13 = $(currentItem).data('id');
        Start13 = $(currentItem).data('start');
        $("#ChooseYourCandidate13").remove();
        $("#flip-items13").removeClass("position-absolute");
        Flag13 = false;
      },
    });
    $("#Carousel14").flipster({
      style: 'carousel',
      spacing: -0.5,
      buttons: true,
      itemcontainer: 'ul',
      itemselector: 'li',
      enableTouch: true,
      start: Start14,
      loop: true,
      click: true,
      onItemSwitch: function (currentItem) {
        Id14 = $(currentItem).data('id');
        Start14 = $(currentItem).data('start');
        $("#ChooseYourCandidate14").remove();
        $("#flip-items14").removeClass("position-absolute");
        Flag14 = false;
      },
    });
    $("#Carousel15").flipster({
      style: 'carousel',
      spacing: -0.5,
      buttons: true,
      itemcontainer: 'ul',
      itemselector: 'li',
      enableTouch: true,
      start: Start15,
      loop: true,
      click: true,
      onItemSwitch: function (currentItem) {
        Id15 = $(currentItem).data('id');
        Start15 = $(currentItem).data('start');
        $("#ChooseYourCandidate15").remove();
        $("#flip-items15").removeClass("position-absolute");
        Flag15 = false;
      },
    });

    $("#back").click(function (event) {
      if (Flag1 === "true" || Flag2 === "true" || Flag3 === "true" || Flag4 === "true" || Flag5 === "true" ||
        Flag6 === "true" || Flag7 === "true" || Flag8 === "true" || Flag9 === "true" || Flag10 === "true" ||
        Flag11 === "true" || Flag12 === "true" || Flag13 === "true" || Flag14 === "true" || Flag15 === "true") {
        Swal.fire({
          title: 'Please Choose Your Candidate',
          icon: 'error',
          showCancelButton: false,
          confirmButtonText: 'Okay'
        })
      } else if (campus == "Tagum" && (Id11 === Id12 && (Id11 != 0 && Id12 != 0))) {
        Swal.fire({
          title: 'Please Choose One Candidate Only For Business Manager',
          icon: 'error',
          showCancelButton: false,
          confirmButtonText: 'Okay'
        })
      } else if (campus == "Tagum" && ((Id13 === Id14 || Id15 === Id13 || Id15 === Id14) && (Id13 != 0 && Id14 != 0 && Id15 != 0))) {
        Swal.fire({
          title: 'Please Choose One Candidate Only For Senator',
          icon: 'error',
          showCancelButton: false,
          confirmButtonText: 'Okay'
        })
      } else {
        Swal.fire({
          title: 'Do you want to go back?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#1ba205',
          cancelButtonColor: '#A24D4D',
          confirmButtonText: 'Yes',
          closeOnConfirm: false,
          closeOnCancel: false
        }).then((result) => {
          if (result.value) {
            $.ajax({
              type: "POST",
              url: "../voting-operations/Local_Council/AjaxSessionLocal.php",
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
                'ID11': Id11,
                'ID12': Id12,
                'ID13': Id13,
                'ID14': Id14,
                'ID15': Id15,

                'ST1': Start1,
                'ST2': Start2,
                'ST3': Start3,
                'ST4': Start4,
                'ST5': Start5,
                'ST6': Start6,
                'ST7': Start7,
                'ST8': Start8,
                'ST9': Start9,
                'ST10': Start10,
                'ST11': Start11,
                'ST12': Start12,
                'ST13': Start13,
                'ST14': Start14,
                'ST15': Start15
              },
              success: function (result) {
                window.location = 'VotingStudentCouncil.php';
              },
              error: function (ts) {
                console.log(ts.responseText);
                Swal.fire({
                  title: 'Database Error in AjaxSessionLocal.php!',
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
      $("#submit").click(function (event) {
        if (Flag1 === "true" || Flag2 === "true" || Flag3 === "true" || Flag4 === "true" || Flag5 === "true" ||
          Flag6 === "true" || Flag7 === "true" || Flag8 === "true" || Flag9 === "true" || Flag10 === "true" ||
          Flag11 === "true" || Flag12 === "true" || Flag13 === "true" || Flag14 === "true" || Flag15 === "true") {
          Swal.fire({
            title: 'Please Choose Your Candidate',
            icon: 'error',
            showCancelButton: false,
            confirmButtonText: 'Okay'
          });
        } else if (campus == "Tagum" && (Id11 === Id12 && (Id11 != 0 && Id12 != 0))) {
          Swal.fire({
            title: 'Please Choose One Candidate Only For Business Manager',
            icon: 'error',
            showCancelButton: false,
            confirmButtonText: 'Okay'
          })
        } else if (campus == "Tagum" && ((Id13 === Id14 || Id15 === Id13 || Id15 === Id14) && (Id13 != 0 && Id14 != 0 && Id15 != 0))) {
          Swal.fire({
            title: 'Please Choose One Candidate Only For Senator',
            icon: 'error',
            showCancelButton: false,
            confirmButtonText: 'Okay'
          })
        } else {
          $.ajax({
            type: "POST",
            url: "../voting-operations/Local_Council/AjaxSessionLocal.php",
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
              'ID11': Id11,
              'ID12': Id12,
              'ID13': Id13,
              'ID14': Id14,
              'ID15': Id15,

              'ST1': Start1,
              'ST2': Start2,
              'ST3': Start3,
              'ST4': Start4,
              'ST5': Start5,
              'ST6': Start6,
              'ST7': Start7,
              'ST8': Start8,
              'ST9': Start9,
              'ST10': Start10,
              'ST11': Start11,
              'ST12': Start12,
              'ST13': Start13,
              'ST14': Start14,
              'ST15': Start15
            },
            success: function () {
              $.ajax({
                type: "POST",
                url: "../voting-operations/AjaxSummary.php",
                dataType: 'json',
                data: {
                  'campus': "<?php echo $_SESSION["Usep-Comelec"] ?>",
                  'college': "<?php echo $college ?>",
                  'ID1': "<?php echo $_SESSION["Id"][0] ?>",
                  'ID2': "<?php echo $_SESSION["Id"][1] ?>",
                  'ID3': "<?php echo $_SESSION["Id"][2] ?>",
                  'ID4': "<?php echo $_SESSION["Id"][3] ?>",
                  'ID5': "<?php echo $_SESSION["Id"][4] ?>",
                  'ID6': "<?php echo $_SESSION["Id"][5] ?>",
                  'ID7': "<?php echo $_SESSION["Id"][6] ?>",
                  'ID8': "<?php echo $_SESSION["Id"][7] ?>",
                  'ID9': "<?php echo $_SESSION["Id"][8] ?>",
                  'ID10': "<?php echo $_SESSION["Id"][9] ?>",

                  'IDLocal1': Id1,
                  'IDLocal2': Id2,
                  'IDLocal3': Id3,
                  'IDLocal4': Id4,
                  'IDLocal5': Id5,
                  'IDLocal6': Id6,
                  'IDLocal7': Id7,
                  'IDLocal8': Id8,
                  'IDLocal9': Id9,
                  'IDLocal10': Id10,
                  'IDLocal11': Id11,
                  'IDLocal12': Id12,
                  'IDLocal13': Id13,
                  'IDLocal14': Id14,
                  'IDLocal15': Id15
                },
                success: function (response) {
                  console.log(response);
                  $('#summary').modal('show');
                  for (var count = 0; count < response[1].length; count++) {
                    if (response[1][count] == 0) {
                      $('#' + (count + 1)).remove();
                    } else {
                      $('#' + (count + 1)).html('<b>' + response[1][count] + '</b> <br>' + response[0]
                        [count]);
                    }
                  }
                  for (var count = 0; count < response[3].length; count++) {
                    if (response[3][count] == 0) {
                      $('#Local' + (count + 1)).remove();
                    } else {
                      $('#Local' + (count + 1)).html('<b>' + response[3][count] + '</b> <br>' +
                        response[2][count]);
                    }
                  }
                },
                error: function (ts) {
                  console.log(ts.responseText);
                  Swal.fire({
                    title: 'Database Error in AjaxSummary.php!',
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
            },
            error: function (ts) {
              console.log(ts.responseText);
              Swal.fire({
                title: 'Database Error in AjaxSessionLocal.php!',
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
    });
    $(function () {
      $("#vote").click(function (event) {
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
              url: "../voting-operations/Local_Council/AjaxSubmitLocal.php",
              data: {
                'voter': "<?php echo $_SESSION["saved"] ?>",
                'campus': "<?php echo $_SESSION["Usep-Comelec"] ?>",
                'ID1': "<?php echo $_SESSION["Id"][0] ?>",
                'ID2': "<?php echo $_SESSION["Id"][1] ?>",
                'ID3': "<?php echo $_SESSION["Id"][2] ?>",
                'ID4': "<?php echo $_SESSION["Id"][3] ?>",
                'ID5': "<?php echo $_SESSION["Id"][4] ?>",
                'ID6': "<?php echo $_SESSION["Id"][5] ?>",
                'ID7': "<?php echo $_SESSION["Id"][6] ?>",
                'ID8': "<?php echo $_SESSION["Id"][7] ?>",
                'ID9': "<?php echo $_SESSION["Id"][8] ?>",
                'ID10': "<?php echo $_SESSION["Id"][9] ?>",

                'IDLocal1': Id1,
                'IDLocal2': Id2,
                'IDLocal3': Id3,
                'IDLocal4': Id4,
                'IDLocal5': Id5,
                'IDLocal6': Id6,
                'IDLocal7': Id7,
                'IDLocal8': Id8,
                'IDLocal9': Id9,
                'IDLocal10': Id10,
                'IDLocal11': Id11,
                'IDLocal12': Id12,
                'IDLocal13': Id13,
                'IDLocal14': Id14,
                'IDLocal15': Id15
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
                        campus: "<?php echo $_SESSION["Usep-Comelec"]?>",
                        mode: "Local"
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
                console.log(ts.responseText);
                  Swal.fire({
                  title: 'Database Error in AjaxSubmitLocal.php!',
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
            window.location = 'VotingLocalCouncil.php';
          }
        })
      });
    });
  }
</script>