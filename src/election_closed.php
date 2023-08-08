<?php 
  session_start();

  include 'config/db_config.php';
  include 'includes/date_include.php';

  if($flag == 'false' || $flag1 == 'false' || $flag2 == 'false'){
     header("Location: index.php");
  }

  if(isset($_SESSION['username'])){
    header("location: admin/home.php");
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

    <title>USeP E-Voting | Login</title>
    <link rel="icon" href="img/usep_logo.png">


    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">

    <!-- font awesome cdn -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet"  type='text/css'>
      <link rel="stylesheet" href="css/close.css">
  <style>
    .text-responsive {
    font-size: calc(87% + 0.3vw + 0.3vh);
  }
  </style>
  </head>

  <body>
  <nav class="navbar navbar-expand navbar-dark static-top">
  <div class="container">
     <img id="logo" src="img/usep_logo.png"width="5%" alt="">
     <h4 id="title" class="text-center text-white">USeP E-Voting | Voting Page</h4>
     <img id="logo" class="float-right" src="img/COC Logo2.png" width="5%" alt="">
  </div>
</nav>

    <div class="container">
      <div class="text-center">
      <img src="img/election_stop.png" width="100%">
      </div>
      <div class="text-center breadcrumb"><h2>All Election is finally over. We appreciate you partaking this event.</h2></div>
    </div>  

    <br><br><br>

   <div class="row">
    <div class="col-lg">
      <div class="col-12">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="image-flip">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card shadow-sm p-3 mb-5 bg-white ">
                                <div class="card-body text-center">
                                    <p></p>
                                    <h4 class="card-title"><img width="50%" src="img/campus_logos/mabini_logo.png" alt=""></h4>
                                    <span class="card-text">Mabini Campus Student Council</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="image-flip">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card shadow-sm p-3 mb-5 bg-white">
                                <div class="card-body text-center">
                                    <p></p>
                                    <h4 class="card-title"><img width="50%" src="img/campus_logos/mintal_logo.png" alt=""></h4>
                                    <span class="card-text">Mintal Campus Student Council</span>
                                    <p class="card-text"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="image-flip">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card shadow-sm p-3 mb-5 bg-white">
                                <div class="card-body text-center">
                                    <p></p>
                                    <h4 class="card-title"><img width="50%" src="img/campus_logos/obrero_logo.png" alt=""></h4>
                                    <span class="card-text">Obrero Campus Student Council</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="image-flip">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card shadow-sm p-3 mb-5 bg-white ">
                                <div class="card-body text-center">
                                    <p></p>
                                    <h4 class="card-title"><img width="50%" src="img/campus_logos/tagum_logo.png" alt=""></h4>
                                    <span class="card-text">Tagum Campus Student Council</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

               <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="image-flip">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card shadow-sm p-3 mb-5 bg-white">
                                <div class="card-body text-center">
                                    <p></p>
                                    <h4 class="card-title"><img width="50%" src="img/campus_admin_logo/SSG.png" alt=""></h4>
                                    <span class="card-text">Supreme Student Government</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="image-flip">
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card shadow-sm p-3 mb-5 bg-white">
                                <div class="card-body text-center">
                                    <p></p>
                                    <h4 class="card-title"><img width="50%" src="img/campus_admin_logo/Plebiscite.png" alt=""></h4>
                                    <span class="card-text">Supreme Student Government Congress</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            


        </div>
        </div>
        </div>
          </div>
          </div>

      <!-- Sticky Footer -->
      <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <h6>About</h6>
            <p class="text-justify float-left">This online voting system is an initiative to help students vote for  student and local council officers amidst the pandemic. It gives the students both the chance to vote or run for student body positions.</p>
          </div>

          <div class="col-xs-6 col-md-6">
            <h6>Address</h6>
            <ul class="footer-links">
              <li><span>University of Southeastern Philippines Iñigo St., Bo. Obrero,
              Davao City Philippines 8000</span></li>
          </div>

          <div >
        
          </div>
        </div>
        <hr>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-sm-6 col-xs-12">
            <p class="copyright-text">USeP E-Voting Copyright &copy; <?php echo date('Y') ?> All Rights Reserved by 
         <a href="#">beeEsAyTeA18
        </a>.
        </p>
        </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
            <ul class="campus-logos">
              <li><a  data-toggle="tooltip" title="Click to visit" target="_blank" href="https://www.facebook.com/USePofficial/"><img src="img/social-icons/facebook.png" width="100%" alt=""></a></li>
              <li><a  data-toggle="tooltip" title="Click to visit" target="_blank" href="https://www.youtube.com/watch?v=GDyWK_F_17E"><img src="img/social-icons/youtube.png" width="100%" alt=""></a></li>   
            </ul>
          </div>
        </div>
      </div>
</footer>

<!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>

    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "535744283289207");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v14.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>

         

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script> 

    <!-- sweet alert dialog -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>

    <script src="js/long-press-event-min.js"></script>
    <script src="js/toastr.js"></script>




<!-- hotkeys ctrl+m-->

<script>
document.onkeyup = function(e) {
  if (e.ctrlKey && e.which == 77) {

    Swal.fire({
    title: "Hey!",
    text: "Please enter your access code to continue",
    input: 'text',
    showCancelButton: true,   
    confirmButtonColor: '#A24D4D',
    confirmButtonText: 'Submit'     
}).then((result) => {
    var code = result.value;
    var type= "admin";
    if (result.value) {
      $.ajax({
            type: "POST",
            url: "operations/access_code.php",
            data: {code:code,type:type},
            dataType:'json',
            success:function(response){
              var len =response.length;
              for(var i = 0; i<len; i++){
                  
                  if(response[i]['result'] == 'success'){
                    let timerInterval
                    Swal.fire({
                      title: 'Please standby!',
                      html: 'Redirecting you to admin page in <b></b> milliseconds.',
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
                        window.location.href = 'index_admin.php';

                      }
                    })
                  }else{
                    Swal.fire({
                    title: 'Sorry!',
                    text: "The code you entered was incorrect",
                    confirmButtonColor: '#A24D4D',
                    confirmButtonText: 'Try Again!',
                    imageUrl:'img/error-anim.gif',
                    }).then((result) => {
                    if (result.value) {
                        // location.reload();
                    }
                    })

                  }
               
              }

            }  
            });

    }
});

  }
};
</script>

<script>
var el = document.getElementById('logo');

// listen for the long-press event
el.addEventListener('long-press', function(e) {

  // stop the event from bubbling up
  e.preventDefault()

  Swal.fire({
    title: "Hey!",
    text: "Please enter your access code to continue",
    input: 'text',
    showCancelButton: true,   
    confirmButtonColor: '#A24D4D',
    confirmButtonText: 'Submit'     
}).then((result) => {
    var code = result.value;
    var type= "admin";
    if (result.value) {
      $.ajax({
            type: "POST",
            url: "operations/access_code.php",
            data: {code:code,type:type},
            dataType:'json',
            success:function(response){
              var len =response.length;
              for(var i = 0; i<len; i++){
                  
                  if(response[i]['result'] == 'success'){
                    let timerInterval
                    Swal.fire({
                      title: 'Please standby!',
                      html: 'Redirecting you to admin page in <b></b> milliseconds.',
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
                        window.location.href = 'index_admin.php';

                      }
                    })
                  }else{
                    Swal.fire({
                    title: 'Sorry!',
                    text: "The code you entered was incorrect",
                    confirmButtonColor: '#A24D4D',
                    confirmButtonText: 'Try Again!',
                    imageUrl:'img/error-anim.gif',
                    }).then((result) => {
                    if (result.value) {
                        // location.reload();
                    }
                    })

                  }
               
              }

            }  
            });

    }
});

  
});

</script>


  </body>

</html>
