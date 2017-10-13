
$(function () {
    /*
    function isEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test($email);
    }

    $(document).on('click', '.forgot_pass', function (e) {
        e.preventDefault();
        $('#auth_form').hide();
        $('#auth_form_reg').hide();
        $('#forget_pass_form').show();
        $('#back_to_auth').show();
    });
    $(document).on('click', '#back_to_auth', function (e) {
        e.preventDefault();
        $('#back_to_auth').hide();
        $('#auth_form').show();
        $('#auth_form_reg').show();
        $('#forget_pass_form').hide();
    });

///////////////////////////////auth form/////////////////////////////////////////////////////////////

      $('#auth_form_post').submit(function (e) {
      
        e.preventDefault();
        var error_auth = false;
        if (error_auth == false) {
             
            $.ajax({
                type: "POST",
                url: '/auth/ajax/post',
                data: $(this).serialize(),
                error: function (err) {
                    console.log(err.responseText);
                },
                success: function (data) {
                    var req_status = data[0];
                    if (req_status == 'false') {
                        var req_messages = data[1];

                        $('#err_auth').html(req_messages);
                    } else
                        window.location = "/";

                }
            
            });
        }
        return false;
        
    });
    
//////////////////////////////////////////////reg form////////////////////////////////////////////////////
   
    
    $("#reg_form").submit(function (e) {
        e.preventDefault();
        var erorr = false;
        
        $('#err_req_name').html('');
        $('#err_req_email').html('');
        $('#err_req_password').html('');

        var erorrName = $(this).data("errorname");
        var erorrEmail = $(this).data("erroremail");
        var erorrPassNotMatch = $(this).data("errorepass");
        var errpass = $(this).data("errpass");

        if ($('#name').val() == '' || $('#name').val().length < 1 || $('#name').val().length > 255) {
            $('#err_req_name').html(erorrName);
            erorr = true;
        }
        if (!isEmail($('#email_').val()) || $('#email_').val().length < 4) {
            $('#err_req_email').html(erorrEmail);
            erorr = true;
        }
      
      
        if ($('#password_').val().length < 6) {
            $('#err_req_password').html(errpass);
            erorr = true;
        }
       
      if (erorr == false) {
            $.ajax({
                type: "POST",
                url: '/auth/ajax/registration',
                data: $(this).serialize(),
                error: function (err) {
                    
                    console.log(err.responseText);
                },
                success: function (data) {
                    alert(1);
                    for (arrayIn in data) {
                        $('#err_req_' + arrayIn).html(data[arrayIn][0]);
                    }
                    
                    if (data == '') window.location.href = "/";
                }
            })
           
        }

    });
   
    */
////////////////////////////////////recover email new pass////////////////////////////////////////////////////
   $(document).on('submit', '#auth_form_post_recover_pass', function (e) {
        e.preventDefault();
        var token = $(this).data('token');

        var errpass = $(this).data('errpass');
        var errorepassmatch = $(this).data('errorepassmatch');
        $('#err_first_pass').html('');
        $('#err_secound_pass').html('');
        error_auth = false;

        if ($('#password_auth_recover').val().length < 1 || $('#password_recover').val().length < 1) {
            $('#err_first_pass').html(errpass);
            $('#err_secound_pass').html(errpass);
            error_auth = true;
        }
        if($('#password_auth_recover').val() != $('#password_recover').val())
        {
            $('#err_first_pass').html(errorepassmatch);
            $('#err_secound_pass').html('');
            error_auth = true;
        }
        if (error_auth == false) {

            $.ajax({
                type: "POST",
                url: '/auth/ajax/newpassword/' + token,
                data: $(this).serialize(),
                error: function (err) {
                    console.log(err.responseText);
                },
                success: function (data) {

                    var status = data[0];
                    var messages = data[1];

                    if (status == 'err') {
                        $('#err_recover_email').html(messages);
                    } else {
                        window.location.href = "/";
                    }

                }
            });
        }
    });
    
    ////////////////////////////////////recover email////////////////////////////////////////////////////
    
    $('#post_form_recover_pass').submit(function (e) {
       
        e.preventDefault();
       
        var errmail = $(this).data('errmail');
        $('#err_recover_email').html('');
        $('#recover_email_success').html('');
        error_auth = false;

        
        if (error_auth == false) {

            $.ajax({
                type: "POST",
                url: '/auth/ajax/recovery_pass',
                data: $(this).serialize(),
                error: function (err) {
                    console.log(err.responseText);
                },
                success: function (data) {
                    var status = data[0];
                    var messages = data[1];

                    if (status == 'err') {
                        $('#err_recover_email').html(messages);
                    } else {
                        $('#post_form_recover_pass').hide();
                        $('#recover_email_success').html(messages);
                    }

                }
            });
        }
    });
    
});
