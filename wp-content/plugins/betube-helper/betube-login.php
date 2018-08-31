<?php
/*AjaxLogin */
function ajax_login_init(){

    wp_register_script('ajax-login-script', get_template_directory_uri() . '/js/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');

    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url(),
        'loadingmessage' => esc_html__('Sending user info, please wait...', 'betube-helper')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}

// Execute the action only if the user isn't logged in
require_once( ABSPATH . "wp-includes/pluggable.php" );
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}
/*Second*/
function ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>esc_html__('Wrong username or password.', 'betube-helper')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>esc_html__('Login successful, redirecting...', 'betube-helper')));
    }

    die();
}
/*AjaxLogin */
// changing the logo link from wordpress.org to your site
function betube_login_url() {  return esc_url( home_url( '/' ) ); }
// changing the alt text on the logo to show your site name
function betube_login_title() { return get_option('blogname'); }
// calling it only on the login page
add_filter('login_headerurl', 'betube_login_url');
add_filter('login_headertitle', 'betube_login_title');
?>