<?php
/*
Plugin Name: beTube Helper
Plugin URI: http://joinwebs.com/
Description: BeTube Helper Plugin help you to run betube website login register and blogs posts.
Version: 2.0
Author: JoinWebs
Author URI: http://joinwebs.com/
License: GPLv2
*/
?>
<?php
function betube_helper_textdomain(){ 
	load_plugin_textdomain( 'betube-helper', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'betube_helper_textdomain' );
function betube_movies_category() {
	$labels = array(		
		'name' => _x('Movies Categories', 'taxonomy general name', 'betube-helper'),
		'singular_name'     => _x( 'Movies Category', 'betube-helper' ),
		'search_items'      => __( 'Search Movies Categories', 'betube-helper' ),
		'all_items'         => __( 'All Movies Categories', 'betube-helper'),
		'parent_item'       => __( 'Parent Movies Category', 'betube-helper'),
		'parent_item_colon' => __( 'Parent Movies Category:', 'betube-helper'),
		'edit_item'         => __( 'Edit Movies Category', 'betube-helper'), 
		'update_item'       => __( 'Update Movies Category', 'betube-helper'),
		'add_new_item'      => __( 'Add New Movies Category', 'betube-helper'),
		'new_item_name'     => __( 'New Movies Category', 'betube-helper'),
		'menu_name'         => __( 'Movies Categories', 'betube-helper'),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
	);
	register_taxonomy( 'movies_category', 'movies', $args );	
}
add_action( 'init', 'betube_movies_category', 0 );
	function betube_post_type_movies() {
		$labels = array(
	    	'name' => _x('Movies', 'post type general name', 'betube-helper'),
	    	'singular_name' => _x('Movies', 'post type singular name', 'betube-helper'),
	    	'add_new' => _x('Add New Movie', 'book', 'betube-helper'),
	    	'add_new_item' => __('Add New Movie', 'betube-helper'),
	    	'edit_item' => __('Edit Movie', 'betube-helper'),
	    	'new_item' => __('New Movie', 'betube-helper'),
	    	'view_item' => __('View Movie', 'betube-helper'),
	    	'search_items' => __('Search Movie', 'betube-helper'),
	    	'not_found' =>  __('No Movie found', 'betube-helper'),
	    	'not_found_in_trash' => __('No Movie found in Trash', 'betube-helper'), 
	    	'parent_item_colon' => ''
		);		
		$args = array(
	    	'labels' => $labels,
	    	'public' => true,
	    	'publicly_queryable' => true,
	    	'show_ui' => true, 
	    	'query_var' => true,
	    	'rewrite' => true,
	    	'capability_type' => 'post',
	    	'hierarchical' => false,
	    	'menu_position' => null,
	    	'supports' => array('title','editor', 'thumbnail', 'comments', 'custom-fields'),
			'taxonomies' => array('post_tag', 'movies_categories'),
	    	'menu_icon' => 'dashicons-format-video'
		); 		

		register_post_type('movies', $args ); 				  
	} 

	add_action('init', 'betube_post_type_movies');



/* Register Blog Post Type*/
function betube_blogs_category() {
	$labels = array(		
		'name' => _x('Blogs Categories', 'taxonomy general name', 'betube-helper'),
		'singular_name'     => _x( 'Blogs Category', 'betube-helper' ),
		'search_items'      => __( 'Search Blogs Categories', 'betube-helper'),
		'all_items'         => __( 'All Blogs Categories', 'betube-helper'),
		'parent_item'       => __( 'Parent Blogs Category', 'betube-helper'),
		'parent_item_colon' => __( 'Parent Blogs Category:', 'betube-helper'),
		'edit_item'         => __( 'Edit Blogs Category', 'betube-helper'), 
		'update_item'       => __( 'Update Blogs Category', 'betube-helper'),
		'add_new_item'      => __( 'Add New Blogs Category', 'betube-helper'),
		'new_item_name'     => __( 'New Blogs Category', 'betube-helper'),
		'menu_name'         => __( 'Blogs Categories', 'betube-helper'),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
	);
	register_taxonomy( 'blog_category', 'blog', $args );	
}
add_action( 'init', 'betube_blogs_category', 0 );
	function betube_post_type_blogs() {
		$labels = array(
	    	'name' => _x('Blogs', 'post type general name', 'betube-helper'),
	    	'singular_name' => _x('Blogs', 'post type singular name', 'betube-helper'),
	    	'add_new' => _x('Add New Blog Post', 'book', 'betube-helper'),
	    	'add_new_item' => __('Add New Blog Post', 'betube-helper'),
	    	'edit_item' => __('Edit Blog Post', 'betube-helper'),
	    	'new_item' => __('New Blog Post', 'betube-helper'),
	    	'view_item' => __('View Blog Post', 'betube-helper'),
	    	'search_items' => __('Search Blog Post', 'betube-helper'),
	    	'not_found' =>  __('No Blog Post found', 'betube-helper'),
	    	'not_found_in_trash' => __('No Blog Post found in Trash', 'betube-helper'), 
	    	'parent_item_colon' => ''
		);		
		$args = array(
	    	'labels' => $labels,
	    	'public' => true,
	    	'publicly_queryable' => true,
			'exclude_from_search' => false, 
	    	'show_ui' => true, 
	    	'query_var' => true,
	    	'rewrite' => array( 'slug' => 'blog', 'with_front' => true ),
	    	'capability_type' => 'post',
			'has_archive' => true,
	    	'hierarchical' => false,
	    	'menu_position' => null,
	    	'supports' => array('title','editor', 'thumbnail', 'comments'),
			'taxonomies' => array('post_tag', 'blog_category'),
	    	'menu_icon' => 'dashicons-edit'
		);
		register_post_type('blog', $args );
		//flush_rewrite_rules(true);	
	} 

	add_action('init', 'betube_post_type_blogs');
include_once('twitter-function.php');
require('post-like.php');
// Author add new contact details
add_filter( 'user_contactmethods', 'betube_author_new_contact');
function betube_author_new_contact( $contactmethods ) {
	// Add telefone
	$contactmethods['phone'] = esc_html__( 'Phone', 'betube-helper');
	// add address
	$contactmethods['address'] = esc_html__( 'Address', 'betube-helper');
	//Add Social
	$contactmethods['twitter'] = esc_html__( 'Twitter', 'betube-helper');	
	$contactmethods['facebook'] = esc_html__( 'Facebook', 'betube-helper');	
	$contactmethods['googleplus'] = esc_html__( 'Google Plus', 'betube-helper');
	$contactmethods['linkedin'] = esc_html__( 'Linkedin', 'betube-helper');
	$contactmethods['pinterest'] = esc_html__( 'Pinterest', 'betube-helper');
	$contactmethods['instagram'] = esc_html__( 'Instagram', 'betube-helper');
	$contactmethods['youtube'] = esc_html__( 'YouTube', 'betube-helper');
	$contactmethods['vimeo'] = esc_html__( 'Vimeo', 'betube-helper');
	//Add Location	
	$contactmethods['location'] = esc_html__( 'Location', 'betube-helper');
	//Add Heading Text
	$contactmethods['firsttext'] = esc_html__( 'Profile Heading', 'betube-helper');
	$contactmethods['secondtext'] = esc_html__( 'Profile Second Heading', 'betube-helper');
	
	return $contactmethods;
	
}
// Author add new contact details
/*Login Functions */
function betube_cubiq_login_init () {
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
	global $redux_demo;
	$login = $redux_demo['login'];	
	$reset = $redux_demo['reset'];	
    if ( isset( $_POST['wp-submit'] ) ) {
        $action = 'post-data';
    } else if ( isset( $_GET['reauth'] ) ) {
        $action = 'reauth';
    } else if ( isset($_GET['key']) ) {
        $action = 'resetpass-key';
    }

    // redirect to change password form
    if ( $action == 'rp' || $action == 'resetpass' ) {
        wp_redirect( $login.'/?action=resetpass' );
        exit;
    }
	
	// redirect to change password form
    if ( $action == 'register') {
        wp_redirect( $login.'/?action=resetpass' );
        exit;
    }

    // redirect from wrong key when resetting password
    if ( $action == 'lostpassword' && isset($_GET['error']) && ( $_GET['error'] == 'expiredkey' || $_GET['error'] == 'invalidkey' ) ) {
        wp_redirect($reset.'/?action=forgot&failed=wrongkey' );
        exit;
    }

    if (
        $action == 'post-data'        ||            // don't mess with POST requests
        $action == 'reauth'           ||            // need to reauthorize
        $action == 'resetpass-key'    ||            // password recovery
        $action == 'logout'                         // user is logging out
    ) {
        return;
    }

    wp_redirect( home_url( '/login/' ) );
    exit;
}
add_action('login_init', 'betube_cubiq_login_init');
function betube_cubiq_registration_redirect ($errors, $sanitized_user_login, $user_email) {
	global $redux_demo;
	$login = $redux_demo['login'];	
	$register = $redux_demo['register'];	
    // don't lose your time with spammers, redirect them to a success page
    if ( !isset($_POST['confirm_email']) || $_POST['confirm_email'] !== '' ) {

        wp_redirect($login. '?action=register&success=1' );
        exit;

    }

    if ( !empty( $errors->errors) ) {
        if ( isset( $errors->errors['username_exists'] ) ) {

            wp_redirect( $register . '?action=register&failed=username_exists' );

        } else if ( isset( $errors->errors['email_exists'] ) ) {

            wp_redirect( $register . '?action=register&failed=email_exists' );

        } else if ( isset( $errors->errors['empty_username'] ) || isset( $errors->errors['empty_email'] ) ) {

            wp_redirect($register . '?action=register&failed=empty' );

        } else if ( !empty( $errors->errors ) ) {

            wp_redirect( $register . '?action=register&failed=generic' );

        }

        exit;
    }

    return $errors;

}
add_filter('registration_errors', 'betube_cubiq_registration_redirect', 10, 3);
/*Login Function*/
/* Filter Email */
add_filter ("wp_mail_content_type", "betube_mail_content_type");
function betube_mail_content_type() {
	return "text/html";
}
/* Filter Name */
add_filter('wp_mail_from_name', 'betube_blog_name_from_name');
function betube_blog_name_from_name($name = '') {
     return get_bloginfo('name');
}
/* Filter Email */
add_filter ("wp_mail_from", "betube_mail_from");
function betube_mail_from() {
	$sendemail =  get_bloginfo('admin_email');
	return $sendemail;
}
/* Filter Email */

// Add Widget
require('widgets/recent-video-post.php');
require('widgets/most-viewed-post.php');
require('widgets/most-viewed-slider-widget.php');
require('widgets/categories.php');
require('widgets/category-tabber.php');
require('widgets/twitter_widget.php');
//Magzine Widgets
require('widgets/recent-mag-posts.php');
require('widgets/most-viewed-mag-posts.php');
require('widgets/mag-categories.php');
require('widgets/most-viewed-mag-silder-post.php');
// Add AJAX LOGIN
require('betube-login.php');
define('CONCATENATE_SCRIPTS', false);
?>