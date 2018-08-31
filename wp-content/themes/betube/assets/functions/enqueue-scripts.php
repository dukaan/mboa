<?php
function betube_scripts() {
  global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
    
    // Load What-Input files in footer
    wp_enqueue_script( 'what-input', get_template_directory_uri() . '/vendor/what-input/what-input.min.js', array(), '', true );
    
    // Adding Foundation scripts file in the footer
    wp_enqueue_script( 'foundation', get_template_directory_uri() . '/vendor/foundation-sites/dist/foundation.js', 'jquery', '6.2.1', true );	
    
    // Adding scripts file in the footer
    wp_enqueue_script( 'site', get_template_directory_uri() . '/assets/js/scripts.js', 'jquery', '', true );
    
     // Register Motion-UI
    wp_enqueue_style( 'motion-ui', get_template_directory_uri() . '/vendor/motion-ui/dist/motion-ui.min.css', array(), '', 'all' );	

    // Register main stylesheet
    wp_enqueue_style( 'site', get_template_directory_uri() . '/assets/css/style.css', array(), '', 'all' );

    // Comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }
}
add_action('wp_enqueue_scripts', 'betube_scripts', 999);