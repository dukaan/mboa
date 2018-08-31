jQuery(document).ready(function($) {

    // Show the login dialog box on click
    jQuery('a#show_login').on('click', function(e){
        jQuery('body').prepend('<div class="login_overlay"></div>');
        jQuery('form#login').fadeIn(500);
        jQuery('div.login_overlay, form#login a.close').on('click', function(){
            jQuery('div.login_overlay').remove();
            jQuery('form#login').hide();
        });
        e.preventDefault();
    });

    // Perform AJAX login on form submit
    jQuery('form#login').on('submit', function(e){
        jQuery('form#login .login-form p.status').show().text(ajax_login_object.loadingmessage);
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': jQuery('form#login #username').val(), 
                'password': jQuery('form#login #password').val(), 
                'security': jQuery('form#login #security').val() },
            success: function(data){
                jQuery('.login-form p.status').text(data.message);
                if (data.loggedin == true){
                    document.location.href = ajax_login_object.redirecturl;
                }
            }
        });
        e.preventDefault();
    });

});