$(function() {
    
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


    $('#btn_facebook').click(function () {
        var win         =   window.open('/auth/facebook', "facebook", 'width=500, height=300');
        var a = 0;
        var pollTimer   =   window.setInterval(function() {
            try {
               // console.log(win.document.URL.indexOf(window.location.hostname));

                if(win.document.URL.indexOf(window.location.hostname)==7){
                    window.clearInterval(pollTimer);
                    var url =   win.document.URL;
                    acToken =   gup(url, 'access_token');
                    tokenType = gup(url, 'token_type');
                    expiresIn = gup(url, 'expires_in');
                    win.close();
                    validateToken(acToken);
                    location.reload();

                }

                a++;
            } catch(e) {
                console.log(win.document.URL.indexOf(window.location.hostname));
            }
        }, 500);
    });


  ///////////////////////////REGISTRATION/////////////////////////////////
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
 $("form[name='form_reg']").validate({
  // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      name: {
        required: true,
        minlength: 1,
        maxlength: 255
      },
      email: {
        required: true,
        minlength: 4,
        // Specify that email should be validated
        // by the built-in "email" rule
        email: true
      },
      password: {
        required: true,
        minlength: 6
      },
      password_confirmation: {
          required: true,
          equalTo : "#password_"
      }
    },
    // Specify validation error messages
    messages: {
      name: "Please enter your name",
      
      password_confirmation: {
          equalTo : "Both of password must be same"
      },
      
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 6 characters long"
      },
      email: "Please enter a valid email address"
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
    var submit_btn = $(this).find('button[type=submit]');
       $.ajax({
                type: "POST",
                url: '/auth/ajax/registration',
                data: $(form).serialize(),
                error: function (err) {
                    console.log(err.responseText);
                },
                success: function (data) {
                    // alert(11);
                    // window.location.replace("/");
                    console.log(data);
                    for (arrayIn in data) {
                        $('#err_req_' + arrayIn).html(data[arrayIn][0]);
                    }
                    
                    if (data == '') window.location.href = "/";
                }
            })
      }
    });
  
  ///////////////////LOGIN////////////////////////
  //
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  
  $("form[name='auth_form_post']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
     email: {
        required: true,
        minlength: 4,
        // Specify that email should be validated
        // by the built-in "email" rule
        email: true
      },
      password: {
        required: true,
        minlength: 6
      },
    },
    // Specify validation error messages
    messages: {
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 6 characters long"
      },
      email: "Please enter a valid email address"
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      $.ajax({
                type: "POST",
                url: '/auth/ajax/post',
                data: $(form).serialize(),
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
  });
  
  //////////////////////////// RECOVERY PASSWORD BY EMAIl//////////////////////
 
  $('#post_form_recover_pass').validate({
      
      
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      email: {
        required: true,
        minlength: 1,
      },
  },
    // Specify validation error messages
    messages: {
      email: "Please enter a valid email address",
      },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
     
      $.ajax({
                type: "POST",
                url: '/auth/ajax/recovery_pass',
                data: $(form).serialize(),
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
                        $('#err_recover_email').html('');
                        $('#recover_email_success').html(messages);
                    }

                }
         });
    }
  });
  
  
  //////////////////////////RECOVER PASSWORD////////////////////////////////
  
  $('#auth_form_post_recover_pass').validate({
      
      
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
        password: {
        required: true,
        minlength: 6
        },
         password_confirmation: {
          required: true,
          equalTo : "#password_auth_recover"
        }
    },
    // Specify validation error messages
    messages: {
      email: "Please enter a valid email address",
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 6 characters long"
      },
      password_confirmation: {
        equalTo : "Both of password must be the same"
      },
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
        
        var token = $(form).data('token');
        $.ajax({
                type: "POST",
                url: '/auth/ajax/newpassword/' + token,
                data: $(form).serialize(),
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
});