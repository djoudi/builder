jQuery(document).ready(function($) {

    $('#pl_lead_register_form').submit(function(e) {
        e.preventDefault();

        $this = $(this);
        nonce = $(this).find('#register_nonce_field').val();
        username = $(this).find('#user_email').val();
        email = $(this).find('#user_email').val();
        password = $(this).find('#user_password').val();
        confirm = $(this).find('#user_confirm').val();
        name = $(this).find('#user_fname').val();
        phone = $(this).find('#user_phone').val();

        data = {
            action: 'pl_register_lead',
            username: username,
            email: email,
            nonce: nonce,
            password: password,
            confirm: confirm,
            name: name,
            phone: phone
        };

        $.post(info.ajaxurl, data, function(response) {
            if (response) {             
                $('#form_message_box').html(response);
                $('#form_message_box').fadeIn('fast');
            } else {
                $('#form_message_box').html('You have been successfully signed up. This page will refresh momentarily.');
                $('#form_message_box').fadeIn('fast');
                setTimeout(function () {
                    window.location.href = window.location.href;
                }, 700);
                return true;
            }
        });

    });
    
    // beat Chrome's HTML5 tooltips for form validation
    $('form#pl_login_form input[type="submit"]').on('mousedown', function() {
      validate_login_form();
    });

    // initialize validator and add the custom form submission logic
    $("form#pl_login_form").bind('submit',function(e) {

      // prevent default form submission logic
      e.preventDefault();
      var form = $(this);
       
      if ($('.invalid', this).length) {
        return false;
      };

       username = $(form).find('#user_login').val();
       password = $(form).find('#user_pass').val();
       remember = $(form).find('#rememberme').val();

       return login_user (username, password, remember);
    });
    
    if(typeof $.fancybox == 'function') {
        // Register Form Fancybox
        $(".pl_register_lead_link").fancybox({
            'hideOnContentClick': false,
            'scrolling' : true,
            onClosed : function () {
              $(".login-form-validator-error").remove();
            }
        });
        // Login Form Fancybox
        $(".pl_login_link").fancybox({
            'hideOnContentClick': false,
            'scrolling' : true,
            onClosed : function () {
              $(".login-form-validator-error").remove();
            }
            
        });

        $(document).ajaxStop(function() {
            favorites_link_signup();
        });
    }

    favorites_link_signup();

    function favorites_link_signup () {
        if(typeof $.fancybox == 'function') {
            $('.pl_register_lead_favorites_link').fancybox({
              'hideOnContentClick': false,
              'scrolling' : true
            }); 
        }
    }
    
    function login_user (username, password, remember) {
         
       data = {
           action: 'pl_login',
           username: username,
           password: password,
           remember: remember
       };

       var success = false;

       // Need to validate here too, just in case someone press enter in the form instead of pressing submit
       validate_login_form();

       $.ajax({
           url: info.ajaxurl, 
           data: data, 
           async: false,
           type: "POST",
           success: function(response) {
             // console.log(response);
               // If request successfull empty the form
               if ( response == '"You have successfully logged in."' ) {
                 
                 event.preventDefault ? event.preventDefault() : event.returnValue = false;
                 
                 // Get redirect link
                 var redirect = $("input[name='redirect_to']").val();
                 
                 // remove error messages
                 $('.login-form-validator-error').remove();
                 
                 // Remove form
                 $("#pl_login_form_inner_wrapper").slideUp();
                 
                 // Show success message
                 setTimeout(function() {
                   $("#pl_login_form .success").show('fast');
                 },500);
                 
                 // send window to redirect link
                 setTimeout(function () {
                  window.location.href = redirect;
                 }, 1500);
                 
                 success = true;
               } else {
                 // Error Handling
                 var errors = jQuery.parseJSON(response);
                 
                 // jQuery Tools Validator error handling
                 $('form#pl_login_form').validator();
                 
                 if ((typeof errors.user_login != 'undefined') && (typeof errors.user_pass != 'undefined')) {
                   $('form#pl_login_form input').data("validator").invalidate({'user_login':errors.user_login,'user_pass':errors.user_pass});
                 } else if (typeof errors.user_login != 'undefined') {
                   $('form#pl_login_form input').data("validator").invalidate({'user_login':errors.user_login});
                 } else if (typeof errors.user_pass != 'undefined') {
                   $('form#pl_login_form input').data("validator").invalidate({'user_pass':errors.user_pass});
                 }
                 
               }
           }
       });

       // allow page redirect of page on success
       if ( ! success ) {
          return false;
        } else {
          return true;
        }
    }

    function validate_login_form () {
      
      var this_form = $('form#pl_login_form');

      // get fields that are required from form and execture validator()
      var inputs = $(this_form).find("input[required]").validator({
          messageClass: 'login-form-validator-error', 
          offset: [10,0],
          message: "<div><span></span></div>",
          position: 'top center'
        });

      // check required field's validity
      inputs.data("validator").checkValidity();
  }

  // Catch "Enter" keystroke and block it from submitting, except on Submit button
  $('#pl_login_form').bind("keypress", function(e) {
    var code = e.keyCode || e.which;
    if (code  == 13) {
      validate_login_form();
    }
  });
});