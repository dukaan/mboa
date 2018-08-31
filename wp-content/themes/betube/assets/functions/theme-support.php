<?php
	
// Adding WP Functions & Theme Support
function betube_theme_support() {
	
	//WooCommerce
	add_theme_support( 'woocommerce');
	
	//Custom Background
	add_theme_support( 'custom-background' );
	
	//Feed Links
	add_theme_support( 'automatic-feed-links' );
	
	// Add WP Thumbnail Support
	add_theme_support( 'post-thumbnails' );	
	
	// Default thumbnail size
	set_post_thumbnail_size(750, 500, true);
	add_image_size( 'beetube-fslider', 400, 300, true );
	add_image_size( 'beetube-movies', 185, 274, false );
	 // Track views
    add_action( 'wp_head', 'betube_track_post_views');
	
	// Theme page titles
    add_filter( 'wp_title', 'betube_wp_title', 10, 2 );
	
	// Category new fields (the form)
	add_filter('add_category_form', 'betube_my_category_fields');
	add_filter('edit_category_form', 'betube_my_category_fields');
	
	// Update category fields
    add_action( 'edited_category', 'betube_update_my_category_fields', 10, 2 );  
    add_action( 'create_category', 'betube_update_my_category_fields', 10, 2 );
	
	// Enque Media
	add_action('wp_enqueue_scripts', 'betube_add_media_upload_scripts');
	add_action( 'admin_enqueue_scripts', 'betube_wp_media_files' );
	add_action( 'admin_enqueue_scripts', 'cat_enqueue_script' );
	

	// Add RSS Support
	add_theme_support( 'automatic-feed-links' );
	
	// Add Support for WP Controlled Title Tag
	add_theme_support( 'title-tag' );
	
	// Add HTML5 Support
	add_theme_support( 'html5', 
	         array( 
	         	'comment-list', 
	         	'comment-form', 
	         	'search-form', 
	         ) 
	);
	
	// Adding post format support
	 add_theme_support( 'post-formats',		
		array(
			'image',             // an image
			'video',             // video
			'audio',             // audio
		)
	); 
	
	// Set the maximum allowed width for any content in the theme, like oEmbeds and images added to posts.
	$GLOBALS['content_width'] = apply_filters( 'betube_theme_support', 1200 );	
	
	// Add Colors
	require get_template_directory() . '/inc/colors.php';
	
	// Add Page Meta
	require get_template_directory() . '/inc/page_meta.php';
	
	// Add Post Meta
	require get_template_directory() . '/inc/post_meta.php';
	
	//Add Breadcrumbs
	require get_template_directory() . '/inc/breadcrumbs.php';
	
	//Add email functions
	require get_template_directory() . '/inc/betube-email.php';
	
	//Add Video Function
	require get_template_directory() . '/inc/video-functions.php';
	
	// Add Widget	
	
	if ( version_compare( $GLOBALS['wp_version'], '4.0-alpha', '<' ) )
		require get_template_directory() . '/inc/back-compat.php'; 
	
	//Include the TGM_Plugin_Activation class.    
	require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
    add_action( 'tgmpa_register', 'betube_register_required_plugins' );
	
} /* end theme support */

add_action( 'after_setup_theme', 'betube_theme_support' );