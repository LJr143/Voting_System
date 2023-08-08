
    $(document).ready(function(){
    $('.customer-logos').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        arrows: false,
        dots: false,
        pauseOnHover: false,
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 520,
            settings: {
                slidesToShow: 2
            }
        }]
    });
});

$(document).ready(function() {
    $(function () {
    $("#login").click(function (event) {
        var username = $("#inputUsername").val();
        var password = $("#inputPassword").val();
        var campus = $("#campus").val();
    {
        $.ajax({
        type: "POST",
        url: "operations/login_user.php",
        data: {username:username,password:password,campus:campus},
        dataType:'json',
        success:function(response){
          
            var len = response.length;

            $("#college").empty();
            for( var i = 0; i<len; i++){
                var login_result = response[i]['login_result'];
                if(login_result == "success"){
  
                 window.location = 'admin/please_wait.php';

              }else if(login_result == "wrong_password"){
                Swal.fire({
                title: 'Login Failed!',
                text: "Incorrect username or password",
                icon: 'error',
                confirmButtonColor: '#A24D4D',
                confirmButtonText: 'Try Again',
                }).then((result) => {
                if (result.value) {
                    // location.reload();
                }
                })
              }else if(login_result == "watcher_success"){
                
                window.location = 'watcher/please_wait.php';
              
              }else if(login_result == "campus_error"){
                Swal.fire({
                title: 'Login Failed!',
                text: "Please choose your campus",
                icon: 'error',
                confirmButtonColor: '#A24D4D',
                confirmButtonText: 'Try Again!'
                }).then((result) => {
                if (result.value) {
                    // location.reload();
                }
                })
              }else if(login_result == "empty_fields"){
                Swal.fire({
                title: 'Login Failed!',
                text: "Some fields are empty. Make sure to fill in all fields.",
                icon: 'error',
                confirmButtonColor: '#A24D4D',
                confirmButtonText: 'Try Again!'
                }).then((result) => {
                if (result.value) {
                    // location.reload();
                }
                })
              }else if(login_result == "central_admin_success"){

                window.location = 'central-admin/please_wait.php';
                
              }else if(login_result == "ssg_success"){

                window.location = 'ssg/please_wait.php';

              }else if(login_result == "tech_success"){
        
                window.location = 'tech-access/please_wait.php';
                 

              }else if(login_result == "monitor_success"){

              
                window.location = 'monitor-admin/please_wait.php';

              }else{
                Swal.fire({
                title: 'Login Failed!',
                text: "Account does not exist in our database!",
                icon: 'error',
                confirmButtonColor: '#A24D4D',
                confirmButtonText: 'Try Again!'
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
});




  function showPassword() {
  var x = document.getElementById("inputPassword");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
 


document.onkeyup = function(e) {
  if (e.ctrlKey && e.which == 66) {

    Swal.fire({
    title: "Hey!",
    text: "Please enter your access code to continue",
    input: 'text',
    showCancelButton: true,   
    confirmButtonColor: '#A24D4D',
    confirmButtonText: 'Submit'     
}).then((result) => {
    var code = result.value;
    var type= "student";
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
                      html: 'Redirecting you to student voting page in <b></b> milliseconds.',
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
                        window.location.href = 'index.php';

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
    var type= "student";
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
                      html: 'Redirecting you to student voting page in <b></b> milliseconds.',
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
                        window.location.href = 'index.php';

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




$(function () {
    // Toastr options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-left",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "3000",
        "hideDuration": "10000",
        "timeOut": "200000",
        "extendedTimeOut": "100000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.info("Hey, Welcome back. Please login to get started.");

});




$('.custom-control-input').click(function() {
  $('.custom-control-input').not(this).prop('checked', false);
});


