
$(document).ready(function(){


$(document).ready(function(){
var table = $('#usersTable').DataTable( {
"columnDefs": [ {
    "targets": -1,
    "data": null,
    "defaultContent": "<button class='btn btn-warning text-white' data-toggle='modal' data-target='#editUserModal'> <i class='fa fa-pencil-square' aria-hidden='true'></i></button> " +
        "<button class='btn btn-danger' id='deleteUser' data-toggle='modal' data-target='#deleteUserModal'> <i class='fa fa-trash' aria-hidden='true'></i></button>\n"
} ]
} );

var buttons3 = new $.fn.dataTable.Buttons(table, {
    buttons: [
            {
                extend:'excel',
                text: '<i class="fa fa-print" aria-hidden="true"></i> Export',
                className: 'btn btn-success',
                titleAttr:'Export to Excel',
                title:'Users List'
            },
        ]
}).container().appendTo($('#buttons'));

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

          $("#saveUser").click(function(){
                var fname = $("#firstName").val();
                var lname = $("#lastName").val();
                var userType = $("#userType").val();
                var username = $("#username").val();
                var password = $("#password").val();
                var confirmPassword = $("#confirmPassword").val();

                if(fname == "" || lname == "" || username == "" || password == "" || confirmPassword == ""){
                    toastr.warning("Please fill in all fields");
                }else{

                    if(userType == "Select User Type"){
                        toastr.warning("Please select a user type");
                    }else{
                        if(password == confirmPassword){
                            
                            $.ajax({
                            type:"POST",
                            url:"../operations/addUser.php",
                            data:{fname:fname, lname:lname, userType:userType,username:username ,password:password, confirmPassword:confirmPassword},
                            dataType:"json",
                            beforeSend:function(data){
                            },
                            success:function(data){
                                Swal.fire({
                                title: 'Success',
                                text: "New user was added successfully",
                                imageUrl:"../img/gifs/success.gif",
                                confirmButtonColor: '#7e0308',
                                confirmButtonText: 'Ok'
                                }).then((result) => {
                                if (result.value) {
                                    location.reload();
                                }
                                })
                            },
                            error:function(data){
                                Swal.fire({
                                title: 'Error Adding User',
                                text: "The user you entered already exists in the database",
                                imageUrl:"../img/gifs/error.gif",
                                confirmButtonColor: '#7e0308',
                                confirmButtonText: 'Ok'
                                }).then((result) => {
                                if (result.value) {
                                    location.reload();
                                }
                                })
                            }

                        });


                        }else{
                            toastr.error("Passwords does not match");
                        }
                    }
                }

          });


    $('#usersTable tbody').on('click', 'button', function() {
        var data = table.row($(this).parents('tr')).data();
        $("#newFirstName").val(data[0]);
        $("#newLastName").val(data[1]);
        $('#newUserType option[value=' + data[4].replace("&gt;", "") + ']').attr('selected', 'selected');
        $("#newUsername").val(data[2]);
        var userID = data[5];
        $("#saveUserUpdate").data("userID", userID);
        console.log(userID);
    });

    $("*[data-target='#deleteUserModal']").click(function() {
        var userID = $("#saveUserUpdate").data("userID");
        if (userID) {
            showDeleteConfirmation(userID);
        }
    });

    function showDeleteConfirmation(userID) {
        Swal.fire({
            title: 'Delete User',
            text: "Are you sure you want to permanently delete this user?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7e0308',
            cancelButtonColor: '#CFD4D7',
            confirmButtonText: 'Delete',
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                deleteUser(userID);
            }
        });
    }

    function deleteUser(userID) {
        $.ajax({
            type: "POST",
            url: "../operations/deleteUser.php",
            data: { userID: userID },
            dataType: "json",
            success: function(response) {
                console.log(response);
                if (response[0].result === "success") {
                    showSuccessMessage();
                } else {
                    showErrorDeleteMessage('Something went wrong. Please try again!');
                }
            },
            error: function(xhr, status, error) {
                console.log("XHR status:", status);
                console.log("Error:", error);
                console.log("Response:", xhr.responseText);
                showErrorDeleteMessage('Something went wrong. Please try again!');
            }
        });
    }

    function showSuccessMessage() {
        Swal.fire({
            title: 'Success',
            text: "User was deleted successfully",
            imageUrl: "../img/gifs/success.gif",
            confirmButtonColor: '#7e0308',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.value) {
                location.reload();
            }
        });
    }

    function showErrorDeleteMessage(message) {
        Swal.fire({
            title: 'Error Deleting User',
            text: "Something went wrong. Please try again!\n\n" + message,
            imageUrl: "../img/gifs/error.gif",
            confirmButtonColor: '#7e0308',
            confirmButtonText: 'Ok'
        });
    }



    $("#saveUserUpdate").click(function() {
        // Retrieve userID from the data attribute
        var userID = $(this).data("userID");

        var newFirstName = $("#newFirstName").val();
        var newLastName = $("#newLastName").val();
        var newUserType = $("#newUserType").val();
        var newUsername = $("#newUsername").val();
        var newPassword = $("#newPassword").val();
        var newConfirmPassword = $("#newConfirmPassword").val();
                
                if(newFirstName == "" || newLastName == "" || newUsername == "" || newPassword == "" || newConfirmPassword == ""){
                    toastr.warning("Please fill in all fields");
                }else{
                    if(newUserType == "Select User Type"){
                        toastr.warning("Please select a user type");
                    }else{
                        if(newPassword == newConfirmPassword){
                                
                            Swal.fire({
                                title: 'Update User',
                                text: "Are you sure you want to update this user?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#39291F',
                                cancelButtonColor: '#CFD4D7',
                                confirmButtonText: 'Update',
                                cancelButtonText:"Cancel",
                                }).then((result) => {
                                if (result.isConfirmed) {

                                    $.ajax({
                                    type:"POST",
                                    url:"../operations/updateUser.php",
                                    data:{userID: userID, newFirstName:newFirstName, newLastName:newLastName, newUserType:newUserType,
                                    newUsername:newUsername, newPassword:newPassword, newConfirmPassword:newConfirmPassword},
                                    dataType:"json",
                                    beforeSend:function(data){
                                        console.log(userID);
                                     },
                                    success:function(){
                                        Swal.fire({
                                        title: 'Success',
                                        text: "User was updated successfully",
                                        imageUrl:"../img/gifs/success.gif",
                                        confirmButtonColor: '#221913',
                                        confirmButtonText: 'Ok'
                                        }).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                        })
                                    },
                                    error:function(data){
                                        Swal.fire({
                                        title: 'Error Updating User',
                                        text: "Something went wrong. Please try again!",
                                        imageUrl:"../img/gifs/error.gif",
                                        confirmButtonColor: '#221913',
                                        confirmButtonText: 'Ok'
                                        }).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
                                        })
                                    }

                                });



                                }
                                

                            })
                        }else{
                          toastr.error("Passwords does not match");
                        }
                    }
                }
        });

    



    });

    });
  
