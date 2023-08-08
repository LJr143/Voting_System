<?php
  session_start();
  if(isset($_SESSION["Ticket"])){

  }else{
    header('location:../index.php');
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

  <script src="../jquery/jquery-3.5.0.min.js"></script>
  <script src="../bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>

  <!--flipster Carousel -->
  <link rel="stylesheet" href="../jquery-flipster-carousel/dist/jquery.flipster.min.css">

  <!-- Custom fonts for this template-->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js" rel="stylesheet"
    type="text/css">

  <style>
    body {
      background-color: #f6f9fb;
    }
    .modal-backdrop {
     background-color: rgba(0,0,0,.0001) !important;
    }
    .text-responsive {
      font-size: calc(100% + 1vw + 1vh);
    }
  </style>
</head>

<body class="jumbotron m-0 p-0" onUnload="LogOff()">
  <div class="container-fluid">
    <div class="row">
      <div class="text-center col-12 mt-5">
        <img src="../img/Proxy.gif" width="50%"  height="50%">
        <h1 class="h1 text-danger text-responsive">Misrepresentation of vote detected</h1>
        <p class="display-4 text-responsive">Your vote is void</p>
        <p class="lead" id="piniliay"><p>
        <button id="okay" class="btn btn-primary">Okay</button>
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

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

<script type="text/javascript">
  document. getElementById("okay"). onclick = function () {
    <?php 
      session_unset();
      session_destroy();
    ?>
    location. href = "../index.php";
  };
  $(document).ready(function(){
    var Year = new Date().getFullYear();
      
      $('#piniliay').html('#USePPiniliay'+Year);

      (function (global) {

      if(typeof (global) === "undefined")
      {
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
                if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
                    e.preventDefault();
                }
                // stopping event bubbling up the DOM tree..
                e.stopPropagation();
            };
        
        };

    })(window);
  });
</script>