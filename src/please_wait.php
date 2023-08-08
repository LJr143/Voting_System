<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USeP E-Voting</title>
    <link rel="icon" href="../img/usep_logo.png">
    <link rel="stylesheet" href="../css/preloader.css">
</head>

<body>
<section>
  <div class="preloader">
    <div></div>
    <div></div>
    <div></div>
  </div>
  <span id="by">Please wait a moment..</span>
</section>

 <!-- Bootstrap core JavaScript-->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

<script>
        $(function(){
        setTimeout(function(){
        $("body").fadeOut(1000,function(){
           window.location.href = "../admin/home.php"
        })
    },5000)
 });
    </script>

</body>
</html>