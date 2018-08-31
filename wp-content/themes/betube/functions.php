<?php
/**
 * beTube functions and definitions.
 * @package WordPress
 * @subpackage beTube
 * @since beTube 1.0
 */
 // Translation
if(function_exists('load_theme_textdomain')){
	load_theme_textdomain( 'betube', get_template_directory() . '/languages' );
}	
// Theme support options
require_once(get_template_directory().'/assets/functions/theme-support.php'); 

// WP Head and other cleanup functions
require_once(get_template_directory().'/assets/functions/cleanup.php'); 

// Register scripts and stylesheets
require_once(get_template_directory().'/assets/functions/enqueue-scripts.php'); 

// Register custom menus and menu walkers
require_once(get_template_directory().'/assets/functions/menu.php'); 

// Register sidebars/widget areas
require_once(get_template_directory().'/assets/functions/sidebar.php'); 

// Makes WordPress comments suck less
require_once(get_template_directory().'/assets/functions/comments.php'); 

// Replace 'older/newer' post links with numbered navigation
require_once(get_template_directory().'/assets/functions/page-navi.php'); 

// Adds site styles to the WordPress editor
require_once(get_template_directory().'/assets/functions/editor-styles.php'); 

// Related post function - no need to rely on plugins
require_once(get_template_directory().'/assets/functions/related-posts.php'); 

// Author Favorite
require_once(get_template_directory().'/assets/functions/authorfav.php'); 

// beTube Content Function
require(get_template_directory().'/inc/betubesectionfunction.php');
require(get_template_directory().'/inc/betubecontentfunction.php');

//betube Title
function betube_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'betube' ), max( $paged, $page ) );

	return $title;
}

//End Post Function

function betube_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'betube' );

	/* Translators: If there are characters in your language that are not
	 * supported by Bitter, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$bitter = _x( 'on', 'Bitter font: on or off', 'betube' );

	if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro )
			$font_families[] = 'Montserrat:400,700,400italic,700italic';

		if ( 'off' !== $bitter )
			$font_families[] = 'Lato:400,700';

		$query_args = array(
			'family' => urlencode( implode( '%7C', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = esc_url( add_query_arg( $query_args, "//fonts.googleapis.com/css" ) ) ;
	}

	return $fonts_url;
}

/*Video Thumbnails*/
function betube_video_thumbnail_markup( $markup, $post_id ) {
	$markup .= ' ' . get_post_meta($post_id, 'jtheme_video_code', true);
	$markup .= ' ' . get_post_meta($post_id, 'jtheme_video_url', true);

	return $markup;
}

/* Add filter to modify markup */
add_filter( 'video_thumbnail_markup', 'betube_video_thumbnail_markup', 10, 2 );

/*Video Thumbnails*/
/**
 * Plugin: Automatic Youtube Video Posts
 *
 * @url http://wordpress.org/extend/plugins/automatic-youtube-video-posts/
 */

/**
 * Remove filter from the_content that added by Automatic Youtube 
 * Video Posts plugin, because we have integrated it with our theme.
 */
remove_filter('the_content','WP_ayvpp_content');


/* Register the required plugins for this theme.*/

function betube_register_required_plugins() {
 
    /**
     * Array of plugin arrays. Required keys are name, slug and required.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
		
		// Redux Framework
        array(            
			'name' => esc_html__( 'Redux Framework', 'betube' ),
            'slug' => 'redux-framework',
            'required' => true,
            'force_activation' => false,
            'force_deactivation' => false
        ),
        
		// Newsletter
        array(
            'name' => esc_html__( 'Newsletter', 'betube' ),
            'slug' => 'newsletter',            
            'required' => false,            
            'force_activation' => false,
            'force_deactivation' => false
        ),
		
		// Font Awesome 4 Menus
        array(
            'name' => esc_html__( 'Font Awesome 4 Menu', 'betube' ),
            'slug' => 'font-awesome-4-menus',            
            'required' => false,            
            'force_activation' => false,
            'force_deactivation' => false
        ),
		// Video Thumbnail
        array(
            'name' => esc_html__( 'Video Thumbnails', 'betube' ),
            'slug' => 'video-thumbnails',            
            'required' => false,            
            'force_activation' => false,
            'force_deactivation' => false
        ),
		// FV Flowplayer Video Player
        array(
            'name' => esc_html__( 'FV Flowplayer Video Player', 'betube' ),
            'slug' => 'fv-wordpress-flowplayer',            
            'required' => true,            
            'force_activation' => false,
            'force_deactivation' => false
        ),
		//AccessPress Social Login Lite
        array(
            'name' => 'AccessPress Social Login Lite',
            'slug' => 'accesspress-social-login-lite',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false
        ),
		array(
            'name' => 'AccessPress Social Share',
            'slug' => 'accesspress-social-share',
            'required' => false,
            'force_activation' => false,
            'force_deactivation' => false
        ),
 
    );
 
    // Change this to your theme text domain, used for internationalising strings
    $theme_text_domain = 'wpcrown';
 
    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'domain'            => 'wpcrown',           // Text domain - likely want to be the same as your theme.
        'default_path'      => '',                           // Default absolute path to pre-packaged plugins
        'parent_menu_slug'  => 'themes.php',         // Default parent menu slug
        'parent_url_slug'   => 'themes.php',         // Default parent URL slug
        'menu'              => 'install-required-plugins',   // Menu slug
        'has_notices'       => true,                         // Show admin notices or not
        'is_automatic'      => false,            // Automatically activate plugins after installation or not
        'message'           => '',               // Message to output right before the plugins table
        'strings'           => array(
            'page_title'                      => __( 'Install Required Plugins', 'betube' ),
				'menu_title'                      => __( 'Install Plugins', 'betube' ),
				'installing'                      => __( 'Installing Plugin: %s', 'betube' ),
				'oops'                            => __( 'Something went wrong with the plugin API.', 'betube' ),
				'notice_can_install_required'     => _n_noop(
					'This theme requires the following plugin: %1$s.',
					'This theme requires the following plugins: %1$s.',
					'betube'
				),
				'notice_can_install_recommended'  => _n_noop(
					'This theme recommends the following plugin: %1$s.',
					'This theme recommends the following plugins: %1$s.',
					'betube'
				),
				'notice_cannot_install'           => _n_noop(
					'Sorry, but you do not have the correct permissions to install the %1$s plugin.',
					'Sorry, but you do not have the correct permissions to install the %1$s plugins.',
					'betube'
				),
				'notice_ask_to_update'            => _n_noop(
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
					'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
					'betube'
				),
				'notice_ask_to_update_maybe'      => _n_noop(
					'There is an update available for: %1$s.',
					'There are updates available for the following plugins: %1$s.',
					'betube'
				),
				'notice_cannot_update'            => _n_noop(
					'Sorry, but you do not have the correct permissions to update the %1$s plugin.',
					'Sorry, but you do not have the correct permissions to update the %1$s plugins.',
					'betube'
				),
				'notice_can_activate_required'    => _n_noop(
					'The following required plugin is currently inactive: %1$s.',
					'The following required plugins are currently inactive: %1$s.',
					'betube'
				),
				'notice_can_activate_recommended' => _n_noop(
					'The following recommended plugin is currently inactive: %1$s.',
					'The following recommended plugins are currently inactive: %1$s.',
					'betube'
				),
				'notice_cannot_activate'          => _n_noop(
					'Sorry, but you do not have the correct permissions to activate the %1$s plugin.',
					'Sorry, but you do not have the correct permissions to activate the %1$s plugins.',
					'betube'
				),
				'install_link'                    => _n_noop(
					'Begin installing plugin',
					'Begin installing plugins',
					'betube'
				),
				'update_link'                     => _n_noop(
					'Begin updating plugin',
					'Begin updating plugins',
					'betube'
				),
				'activate_link'                   => _n_noop(
					'Begin activating plugin',
					'Begin activating plugins',
					'betube'
				),
				'return'                          => __( 'Return to Required Plugins Installer', 'betube' ),
				'dashboard'                       => __( 'Return to the dashboard', 'betube' ),
				'plugin_activated'                => __( 'Plugin activated successfully.', 'betube' ),
				'activated_successfully'          => __( 'The following plugin was activated successfully:', 'betube' ),
				'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'betube' ),
				'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'betube' ),
				'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'betube' ),
				'dismiss'                         => __( 'Dismiss this notice', 'betube' ),
				'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'betube' ),
        )
    );
 
    tgmpa( $plugins, $config );
 
}

if ( ! function_exists( 'betube_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 *
 * @since betube 1.0
 *
 * @return void
 */
function betube_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'betube_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();

	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Returns the URL from the post.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since betube 1.0
 *
 * @return string The Link format URL.
 */
function betube_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Adjusts content_width value for video post formats and attachment templates.
 * @return void
 */
function betube_content_width() {
	global $content_width;

	if ( is_page_template('template-full-width.php'))
		$content_width = 950;
	elseif(is_singular()) {
		global $post;
		$video_layout = $redux_demo['jw_layout'];
		if($video_layout == 1)
			$content_width = 1200;
	}
}
/*Post Views*/
function betube_customize_preview_js() {
	wp_enqueue_script( 'betube-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );
}
// Add Redux Framework

if ( !isset( $redux_demo ) && file_exists( get_template_directory() . '/ReduxFramework/theme-options.php' ) ) {

	require_once( get_template_directory() . '/ReduxFramework/theme-options.php' );

}

/*Tags Widget Limit*/
//Register tag cloud filter callback
add_filter('widget_tag_cloud_args', 'betube_tag_widget_limit');
function betube_tag_widget_limit($args){
	global $redux_demo;
	$tagsnumber= $redux_demo['tags_limit']; 
	//Check if taxonomy option inside widget is set to tags
	if(isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag'){
	  $args['number'] = $tagsnumber; //Limit number of tags
	}

	return $args;
}
/*Attachment ID*/
function betube_get_attachment_id_from_src($image_src) {

    global $wpdb;
    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
    $id = $wpdb->get_var($query);
    return $id;

}
/*Enqueue Media*/
function betube_add_media_upload_scripts() {
	if ( is_admin() ) {
         return;
       }
    wp_enqueue_media();
}

function betube_wp_media_files() {	
  wp_enqueue_media();
}
/*Enqueue Media*/

/*get_avatar_url*/
function betube_get_avatar_url($author_id, $size){
    $get_avatar = get_avatar( $author_id, $size );
	$matches = array();     
   preg_match('/(?<!_)src=([\'"])?(.*?)\\1/',$get_avatar, $matches);	
    return ( $matches[2] );
}
/*Allow User Uploads*/
function betube_allow_users_uploads() {
	$contributor = get_role('contributor');
	$contributor->add_cap('upload_files');
	$contributor->add_cap('delete_published_posts');
	
	$subscriber = get_role('subscriber');
	$subscriber->add_cap('upload_files');
	$subscriber->add_cap('delete_published_posts');

}
add_action('admin_init', 'betube_allow_users_uploads');

if ( current_user_can('subscriber') || current_user_can('contributor') && !current_user_can('upload_files') ) {
    add_action('admin_init', 'betube_allow_contributor_uploads');
}
function betube_allow_contributor_uploads() {	
	$contributor = get_role('contributor');
	$contributor->add_cap('upload_files');
	
    $subscriber = get_role('subscriber');
    $subscriber->add_cap('upload_files');	
}
/*betube_devplus_attachments_wpquery_where*/
add_filter( 'posts_where', 'betube_devplus_attachments_wpquery_where' );
function betube_devplus_attachments_wpquery_where( $where ){
    global $current_user;
	if ( !current_user_can( 'administrator' ) ) {
		if( is_user_logged_in() ){
			// we spreken over een ingelogde user
			if( isset( $_POST['action'] ) ){
				// library query
				if( $_POST['action'] == 'query-attachments' ){
					$where .= ' AND post_author='.$current_user->data->ID;
				}
			}
		}
	}
    return $where;
}

/*Add Thikbox*/
add_action('template_redirect', 'betube_add_scripts'); 
function betube_add_scripts() {
    if (is_singular()) {
      add_thickbox(); 
    }
}
/*Register Scripts */
add_action( 'wp_enqueue_scripts', 'betube_scripts_styles' );
function betube_scripts_styles() {
	//Load Script		
	wp_enqueue_script('matchHeight', get_template_directory_uri() . '/js/jquery.matchHeight.js', 'jquery', '', true);	
	wp_enqueue_script('app', get_template_directory_uri() . '/js/app.js', 'jquery', '', true);	
	wp_enqueue_script('inewsticker', get_template_directory_uri() . '/js/inewsticker.js', 'jquery', '', true);	
	wp_enqueue_script('jquery.kyco.easyshare', get_template_directory_uri() . '/js/jquery.kyco.easyshare.js', 'jquery', '', true);
	wp_enqueue_script('jquery.showmore.src', get_template_directory_uri() . '/js/jquery.showmore.src.js', 'jquery', '', true);	
	wp_enqueue_script('ninja-slider', get_template_directory_uri() . '/js/ninja-slider.js', 'jquery', '', true);	
	wp_enqueue_script('owl.carousel.min', get_template_directory_uri() . '/js/owl.carousel.min.js', 'jquery', '', true);
	wp_enqueue_script('infinitescroll', get_template_directory_uri() . '/js/infinitescroll.js', 'jquery', '', true);
	
	// Load google maps js
    global $redux_demo;
	$googleApiKey = $redux_demo['betube_google_api'];	
    wp_enqueue_script( 'betube-google-maps-script', 'https://maps.googleapis.com/maps/api/js?key='.$googleApiKey.'&v=3.exp', array( 'jquery' ), '2014-07-18', false );	
	// Adds JavaScript to pages with the comment form to support sites with
	// threaded comments (when in use).
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	
// Load CSS 
	wp_enqueue_style( 'app', get_template_directory_uri() . '/css/app.css', array(), '1' );
	global $redux_demo;
	$colorScheme= $redux_demo['betube-light-dark']; 
	if($colorScheme == 'light'){
		wp_enqueue_style( 'betube-theme', get_template_directory_uri() . '/css/theme.css', array(), '1' );
	}else{
		wp_enqueue_style( 'betube-theme', get_template_directory_uri() . '/css/theme-dark.css', array(), '1' );
		wp_enqueue_style( 'betube-responsive-dark', get_template_directory_uri() . '/css/responsive-dark.css', array(), '1' );
	}
	
	wp_enqueue_style( 'hover-min', get_template_directory_uri() . '/css/hover-min.css', array(), '1' );
	wp_enqueue_style( 'jquery.kyco.easyshare', get_template_directory_uri() . '/css/jquery.kyco.easyshare.css', array(), '1' );
	wp_enqueue_style( 'ninja-slider', get_template_directory_uri() . '/css/ninja-slider.css', array(), '1' );
	wp_enqueue_style( 'owl.carousel', get_template_directory_uri() . '/css/owl.carousel.css', array(), '1' );
	wp_enqueue_style( 'owl.theme.default', get_template_directory_uri() . '/css/owl.theme.default.css', array(), '1' );
	wp_enqueue_style( 'betube-responsive', get_template_directory_uri() . '/css/responsive.css', array(), '1' );	
	wp_enqueue_style( 'thumbnail-slider', get_template_directory_uri() . '/css/thumbnail-slider.css', array(), '1' );
	wp_enqueue_style( 'simple-likes-public', get_template_directory_uri() . '/css/simple-likes-public.css', array(), '1' );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '1' );	

	if ( is_rtl() ) {
		wp_enqueue_style( 'foundation-rtl', get_template_directory_uri() . '/css/foundation-rtl.css', array(), '1' );
	}	

}

function cat_enqueue_script(){
	wp_enqueue_script( 'betube-inlinecat', get_template_directory_uri() . '/js/cat.js' );
}
/*function to display extra info on category admin*/
define('BETUBE_CATEGORY_FIELDS', 'my_category_fields_option');
// your fields (the form)
function betube_my_category_fields($tag) {
    $tag_extra_fields = get_option(BETUBE_CATEGORY_FIELDS);	
    $betubeCarIMGURL = isset( $tag_extra_fields[$tag->term_id]['your_image_url'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['your_image_url'] ) : '';
	$category_icon_code = isset( $tag_extra_fields[$tag->term_id]['category_icon_code'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['category_icon_code'] ) : '';
	$category_icon_color = isset( $tag_extra_fields[$tag->term_id]['category_icon_color'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['category_icon_color'] ) : '';
	$category_image = isset( $tag_extra_fields[$tag->term_id]['category_image'] ) ? esc_attr( $tag_extra_fields[$tag->term_id]['category_image'] ) : '';
    ?>
<div class="form-field">	
	<table class="form-table">
		<!--Category Thumbnail-->
		<tr class="form-field">
			<th scope="row" valign="top"><label for="category-page-slider"><?php esc_html_e( 'Category Thumbnail', 'betube' ); ?></label></th>
			<td>
			<?php 

			if(!empty($betubeCarIMGURL)) {

				echo '<div style="width: 100%; float: left;"><img id="your_image_url_img" src="'. $betubeCarIMGURL .'" style="float: left; margin-bottom: 20px;" /> </div>';
				echo '<input id="your_image_url" type="text" size="36" name="your_image_url" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$betubeCarIMGURL.'" />';
				echo '<input id="your_image_url_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Remove" /> </br>';
				echo '<input id="your_image_url_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload Image" /> </br>'; 

			} else {

				echo '<div style="width: 100%; float: left;"><img id="your_image_url_img" src="'. $betubeCarIMGURL .'" style="float: left; margin-bottom: 20px;" /> </div>';
				echo '<input id="your_image_url" type="text" size="36" name="your_image_url" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$betubeCarIMGURL.'" />';
				echo '<input id="your_image_url_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Remove" /> </br>';
				echo '<input id="your_image_url_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload Image" /> </br>';

			}
			?>
			</td>
		</tr>
		<!--Category Thumbnail-->
		<!--Category Icon Image-->
		<tr class="form-field">
            <th scope="row" valign="top"><label for="category-page-slider"><?php esc_html_e( 'Category Icon Image', 'betube' ); ?>&nbsp;Size:70x70px:</label></th>
            <td>
            <?php 
            if(!empty($category_image)) {

                echo '<div style="width: 100%; float: left;"><img id="category_image_img" src="'. $category_image .'" style="float: left; margin-bottom: 20px;" /> </div>';
                echo '<input id="category_image" type="text" size="36" name="category_image" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$category_image.'" />';
                echo '<input id="category_image_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Remove" /> </br>';
                echo '<input id="category_image_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Upload Image" /> </br>'; 

            } else {

                echo '<div style="width: 100%; float: left;"><img id="category_image_img" src="'. $category_image .'" style="float: left; margin-bottom: 20px;" /> </div>';
                echo '<input id="category_image" type="text" size="36" name="category_image" style="max-width: 200px; float: left; margin-top: 10px; display: none;" value="'.$category_image.'" />';
                echo '<input id="category_image_button_remove" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px; display: none;" value="Remove" /> </br>';
                echo '<input id="category_image_button" class="button" type="button" style="max-width: 140px; float: left; margin-top: 10px;" value="Upload Image" /> </br>';

            }

            ?>
            </td>            
        </tr>
		<!--Category Icon Image-->
		<!--Icon Code-->
		<tr class="form-field">
			<th scope="row" valign="top"><label for="category-page-slider"><?php esc_html_e( 'Icon Code', 'betube' ); ?></label></th>
			<td>
				<input id="category_icon_code" type="text" size="36" name="category_icon_code" value="<?php $category_icon = stripslashes($category_icon_code); echo esc_attr($category_icon); ?>" />
				
				<p class="description"><?php esc_html_e( 'AwesomeFont code', 'betube' ); ?>: <a href="http://fontawesome.io/icons/" target="_blank">fontawesome.io/icons</a> Ex: fa fa-desktop</p>
			</td>
		</tr>
		<!--Icon Code-->
		<!--Category Color-->
		<tr class="form-field">
			<th scope="row" valign="top"><label for="category-page-slider"><?php esc_html_e( 'Icon Background Color', 'betube' ); ?></label></th>
			<td>
				<link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_template_directory_uri() ?>/inc/color-picker/css/colorpicker.css" />
				<script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/inc/color-picker/js/colorpicker.js"></script>
				<script type="text/javascript">
				jQuery.noConflict();
				jQuery(document).ready(function(){
					jQuery('#colorpickerHolder').ColorPicker({
						color:'<?php echo $category_icon_color; ?>', 
						flat: true, 
						onChange: function (hsb, hex, rgb) { jQuery('#category_icon_color').val('#' + hex); }
					});
				});
				</script>
				<p id="colorpickerHolder"></p>
				<input id="category_icon_color" type="text" size="36" name="category_icon_color" value="<?php echo $category_icon_color; ?>" style="margin-top: 20px; max-width: 90px; visibility: hidden;" />
			</td>
		</tr>
		<!--Category Color-->
	</table>
</div>

    <?php
}
// when the form gets submitted, and the category gets updated (in your case the option will get updated with the values of your custom fields above
function betube_update_my_category_fields($term_id) {
	if(isset($_POST['taxonomy'])){	
	  if($_POST['taxonomy'] == 'category'):
		$tag_extra_fields = get_option(BETUBE_CATEGORY_FIELDS);
		$tag_extra_fields[$term_id]['your_image_url'] = strip_tags($_POST['your_image_url']);
		$tag_extra_fields[$term_id]['category_icon_code'] = $_POST['category_icon_code'];
		$tag_extra_fields[$term_id]['category_icon_color'] = $_POST['category_icon_color'];
		$tag_extra_fields[$term_id]['category_image'] = $_POST['category_image'];
		update_option(BETUBE_CATEGORY_FIELDS, $tag_extra_fields);
	  endif;
	}
}
// when a category is removed
add_filter('deleted_term_taxonomy', 'betube_remove_my_category_fields');
function betube_remove_my_category_fields($term_id) {
	if(isset($_POST['taxonomy'])){		
	  if($_POST['taxonomy'] == 'category'):
		$tag_extra_fields = get_option(BETUBE_CATEGORY_FIELDS);
		unset($tag_extra_fields[$term_id]);
		update_option(BETUBE_CATEGORY_FIELDS, $tag_extra_fields);
	  endif;
	} 
}
// Post Views
function betube_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
function betube_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;    
    }
    betube_set_post_views($post_id);
}
function betube_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}


/*BeTube Thumb URL */
function betube_thumb_url($post_id){
	global $post;
	$default = "";
	
	if(!$post_id)
		$post_id = $post->ID;	
	
	/* Check if this video has a feature image */
	if(has_post_thumbnail() && $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post_id)))		
		$thumb_url = get_the_post_thumbnail_url(null, 'full');
	
	/* If no feature image, try to get thumbnail by "Video Thumbnails" plugin */
	if(empty($thumb_url) && function_exists('get_video_thumbnail')) {
		$video_thumbnail = get_video_thumbnail($post_id);
		if(!is_wp_error($video_thumbnail))
			$thumb_url = $video_thumbnail;
	}

	/* If this is a video by jplayer, try to get thumbnail from video_posts */
	if(empty($thumb_url) && $poster = get_post_meta($post_id, 'jtheme_video_poster', true))
		$thumb_url = get_post_meta($post_id, 'jtheme_video_poster', true);
	
	/* If still no image or is wp error, define default image */
	if(empty($thumb_url) || is_wp_error($thumb_url)) {
		if($default === false || $default === 0)
			return false;
		
		$thumb_url = !empty($default) ? $default : get_template_directory_uri().'/assets/images/nothumb.jpg';
	}
	return $thumb_url;
} 
function betube_thumb_alt($post_id){
	global $post;
	if(!$post_id)
		$post_id = $post->ID;
	$thumb_id = get_post_thumbnail_id($post->id);
	$alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
	if(empty($alt)){
		$thumAlt = "image";
	}else{
		$thumAlt = $alt;
	}
	return $thumAlt;
}
/**
 * Prepare scripts for ajax calls when needed
 *
 */
add_action('the_post', 'betube_prepare_scripts', 10);
function betube_prepare_scripts($query) {
	if(is_admin())
		return false;
	
	global $post;
	$code = trim(get_post_meta($post->ID, 'jtheme_video_file', true));
	
	if(has_shortcode($code, 'jplayer'))
		wp_enqueue_script('jquery-jplayer');
				
	$library = apply_filters( 'wp_video_shortcode_library', 'mediaelement' );	
	if(has_shortcode($code, 'video') && 'mediaelement' === $library && did_action( 'init' ) ) {
		wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_script( 'wp-mediaelement' );
	}
} 
function arr2atts($array = array(), $include_empty_att = false) {
	if(empty($array))
		return;
	
	$atts = array();
	foreach($array as $key => $att) {
		if(!$include_empty_att && empty($att))
			continue;
		
		$atts[] = $key.'="'.$att.'"';
	}
	
	return ' '.implode(' ', $atts);
}
/*	Infinite Pagination */
if (!function_exists('infinite')) {
	function infinite($query) {
		$pages = intval($query->max_num_pages);
		$paged = (get_query_var('paged')) ? intval(get_query_var('paged')) : 1;
		if (empty($pages)) {
			$pages = 1;
		}
		if (1 != $pages) {
			echo '<p class="jw-pagination jw-infinite-scroll simple-pagination" data-has-next="' . ($paged === $pages ? 'false' : 'true') . '">';
			echo '<a class="btn btn-small no-more" href="#"><i class="fa fa-refresh"></i>' . esc_html_e('No more posts', 'betube') . '</a>';
			echo '<a class="btn btn-small loading" href="#"><i class="fa fa-refresh"></i>' . esc_html_e('Loading posts ...', 'betube') . '</a>';
			echo '<a class="btn btn-small next" href="' . get_pagenum_link($paged + 1) . '"><i class="fa fa-refresh"></i>' . esc_html_e('Load More ', 'betube') . '</a>';
			echo '</p>';
			?>
			<div class="jw-pagination jw-infinite-scroll" data-has-next="<?php echo ($paged === $pages ? 'false' : 'true'); ?>">
				<div class="clearfix">
					
				</div>
				
				<div class="more-btn-main">
					<div class="view-more-separator"></div>
						<div class="view-more-btn">
						<div class="more-btn-inner text-center">
							<a class="next button round" href="<?php echo get_pagenum_link($paged + 1);?>">
								<i class="fa fa-refresh"></i>
								<span><?php esc_html_e( 'load more', 'betube' ); ?></span>
							</a>
							<a class="loading button round">
								<i class="fa fa-refresh"></i>
								<span><?php esc_html_e( 'Loading posts ...', 'betube' ); ?></span>
							</a>
							<a class="no-more button round">
								<i class="fa fa-refresh"></i>
								<span><?php esc_html_e( 'No more posts', 'betube' ); ?></span>
							</a>
						</div>
					</div>				
				</div>		
			</div>
			<?php 
		}
	}
}
/*	Infinite Pagination */
/*Facebook Meta Function */
function betube_facebook_tags(){
	$description = get_bloginfo('description');
	global $redux_demo;
	$beTubeFBAPPID = $redux_demo['betubefbappid'];
	$beTubeFBPlay = $redux_demo['betube-play-on-facebook'];
	if(is_author()){
		$description = get_the_author_meta( 'description' );
		if($description==''){$description = get_bloginfo('description');}
	}
	if(is_single()){
		global $post;		
		$betubeExcerpt = $post->post_excerpt;
		if(empty($betubeExcerpt)){
			$description = $post->post_content;
		}else{
			$description = $betubeExcerpt;
		}
		$betubePostIMG = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
		if(empty($betubePostIMG)){
			$betubeOGIMG = trim(get_post_meta($post->ID, 'jtheme_video_file', true));
		}else{
			$betubeOGIMG = $betubePostIMG;
		}
		
		$url_video = get_post_meta($post->ID,'jtheme_video_url',true);
		if($url_video==''){$url_video = get_permalink($post->ID);}		
		if($beTubeFBPlay == 1){?>
            <meta property="og:title" content="<?php echo get_the_title($post->ID);?>"/>
            <meta property="og:type" content="website" />
            <meta property="og:image" content="<?php echo $betubeOGIMG; ?>"/>
            <meta property="og:url" content="<?php echo get_permalink($post->ID);?>"/>
            <meta property="og:site_name" content="<?php echo get_bloginfo('name');?>"/>        
            <meta property="og:description" content="<?php echo strip_tags($description);?>"/>
            <?php if($beTubeFBAPPID){ ?>
            	<meta property="fb:app_id" content="<?php echo $beTubeFBAPPID; ?>" />
            <?php }?>
		<?php }else{ ?>
            <meta property="og:title" content="<?php echo get_the_title($post->ID);?>"/>
            <meta property="og:type" content="<?php echo get_post_format($post->ID);?>"/>
            <meta property="og:image" content="<?php echo $betubeOGIMG; ?>"/>
            <meta property="og:url" content="<?php echo $url_video;?>"/>
            <meta property="og:site_name" content="<?php echo get_bloginfo('name');?>"/>
            <meta property="og:description" content="<?php echo strip_tags($description);?>"/>
            <?php if($beTubeFBAPPID){ ?>
                <meta property="fb:app_id" content="<?php echo $beTubeFBAPPID;?>" />
            <?php }?>
        <?php 
		}
		if(get_post_format($post->ID) == 'video'){
			$video_file = get_post_meta($post->ID,'jtheme_video_file',true);
			if($video_file != ''){
				$urls = explode(PHP_EOL,$video_file);
				?>
				<meta property="og:video" content="<?php echo $urls[0];?>"/>
				<meta property="og:video:secure_url" content="<?php echo $url_video;?>"/>
				<?php
			}
		
		?>
		<?php }?>
<?php
	}
	?>
	<meta property="description" content="<?php echo strip_tags($description);?>"/>
	<?php
}
/*Facebook Meta Function */
/*Remove Redux Noticed*/
function betuberemoveDemoModeLink() { // Be sure to rename this function to something more unique
    if ( class_exists('ReduxFrameworkPlugin') ) {
        remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
		remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
		
    }    
}
add_action('init', 'betuberemoveDemoModeLink');

// this will deactive demo mode of reduxframework plugin and will not display and addvertisement
if( ! function_exists( 'redux_disable_dev_mode_plugin' ) ) {
        function redux_disable_dev_mode_plugin( $redux ) {
            if ( $redux->args['opt_name'] != 'redux_demo' ) {
                $redux->args['dev_mode'] = false;
            }
        }
        add_action( 'redux/construct', 'redux_disable_dev_mode_plugin' );
    }

/*Remove Redux Noticed*/
/*Admin Styles*/
function betube_admin_style() {
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admincss.css');
}
add_action('admin_enqueue_scripts', 'betube_admin_style');
// Insert attachments front end
function betube_insert_attachment($file_handler,$post_id,$setthumb='false') {
  // check to make sure its a successful upload
  if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

  require_once(ABSPATH . "wp-admin" . '/includes/image.php');
  require_once(ABSPATH . "wp-admin" . '/includes/file.php');
  require_once(ABSPATH . "wp-admin" . '/includes/media.php');

  $attach_id = media_handle_upload( $file_handler, $post_id );

  if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
  return $attach_id;
}
//betube User profile image upload//
function betube_insert_userIMG($file_handler){
	if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();
	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');
	$attach_id = media_handle_upload($file_handler, $post_id = null);	
  return $attach_id;
}
//betube User profile image link//
function betube_get_image_url($attach_id){
	$sourceURL = wp_get_attachment_image_src($attach_id, $size='full');
	$profileURL = $sourceURL[0];
	return $profileURL;
}

function betube_category_posts_per_page( $query ) {
    if ($query->is_category()){
        $query->set( 'posts_per_page', 12 );
	}
}
add_action( 'pre_get_posts', 'betube_category_posts_per_page' );
//beTube Mag functions//
function betube_post_format_display($post_ID){
	$classDisplay = '';
	if(has_post_format('image')){
		$classDisplay = 'fa fa-camera';
	}elseif(has_post_format('video')){
		$classDisplay = 'fa fa-video-camera';
	}elseif(has_post_format('audio')){
		$classDisplay = 'fa fa-file-audio-o';
	}else{
		$classDisplay = 'fa fa-newspaper-o';
	}
	return $classDisplay;
}