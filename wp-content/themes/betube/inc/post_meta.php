<?php
	/*Make it HD*/
	
	add_action( 'add_meta_boxes', 'hd_post' );
	function hd_post() {
	    add_meta_box( 
	        'hd_post',
	        esc_html__( 'IS this HD Post?', 'betube' ),
	        'betubeHDPost',
	        'post',
	        'side',
	        'high'
	    );
	}
	// Show The Post On Slider Option
	function betubeHDPost() {
		global $post;
		
		// Noncename needed to verify where the data originated
		echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . 
		wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
		
		// Get the location data if its already been entered
		$hd_post = get_post_meta($post->ID, 'hd_post', true);
		
		// Echo out the field
		echo '<span class="text overall" style="margin-right: 20px;">Check This for HD:</span>';
		
		$checked = get_post_meta($post->ID, 'hd_post', true) == '1' ? "checked" : "";
		
		echo '<input type="checkbox" name="hd_post" id="hd_post" value="1" '. $checked .'/>';

	}
	
	add_action( 'save_post', 'hd_save_post_meta' );
	// Save the Metabox Data
	function hd_save_post_meta($post_id) {
		global $post;
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( !wp_verify_nonce( isset( $_POST['eventmeta_noncename'] ) ? $_POST['eventmeta_noncename'] : '', plugin_basename(__FILE__) )) {			
			//return $post->ID;
			return $post_id;
		}

		// Is the user allowed to edit the post or page?
		if ( !current_user_can( 'edit_post', $post->ID ))
			return $post->ID;

		// OK, we're authenticated: we need to find and save the data
		// We'll put it into an array to make it easier to loop though.
		
		$events_meta['hd_post'] = $_POST['hd_post'];
		
		$chk = ( isset( $_POST['hd_post'] ) && $_POST['hd_post'] ) ? '1' : '2';
		update_post_meta( $post_id, 'hd_post', $chk );
		
		// Add values of $events_meta as custom fields
		foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!
			if( $post->post_type == 'post' ) return; // Don't store custom data twice
			$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
			if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
				update_post_meta($post->ID, $key, $value);
			} else { // If the custom field doesn't have a value
				add_post_meta($post->ID, $key, $value);
			}
			if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
		}

	}
	/* End */
/*Make it HD*/
	/*Make it Featured*/
	
	add_action( 'add_meta_boxes', 'featured_post' );
	function featured_post() {
	    add_meta_box( 
	        'featured_post',
	        esc_html__( 'Make it Featured post', 'betube' ),
	        'classieraFeaturedPost',
	        'post',
	        'side',
	        'high'
	    );
	}
	// Show The Post On Slider Option
	function classieraFeaturedPost() {
		global $post;
		
		// Noncename needed to verify where the data originated
		echo '<input type="hidden" name="eventmeta_noncename" id="eventmeta_noncename" value="' . 
		wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
		
		// Get the location data if its already been entered
		$featured_post = get_post_meta($post->ID, 'featured_post', true);
		
		// Echo out the field
		echo '<span class="text overall" style="margin-right: 20px;">Is this Featured Post:</span>';
		
		$checked = get_post_meta($post->ID, 'featured_post', true) == '1' ? "checked" : "";
		
		echo '<input type="checkbox" name="featured_post" id="featured_post" value="1" '. $checked .'/>';

	}
	
	add_action( 'save_post', 'wpcrown_save_post_meta' );
	// Save the Metabox Data
	function wpcrown_save_post_meta($post_id) {
		//global $post;
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( !wp_verify_nonce( isset( $_POST['eventmeta_noncename'] ) ? $_POST['eventmeta_noncename'] : '', plugin_basename(__FILE__) )) {
			//return $post->ID;
			return $post_id;
		}

		// Is the user allowed to edit the post or page?
		if ( !current_user_can( 'edit_post', $post->ID ))
			return $post->ID;

		// OK, we're authenticated: we need to find and save the data
		// We'll put it into an array to make it easier to loop though.
		
		$events_meta['featured_post'] = $_POST['featured_post'];
		
		$chk = ( isset( $_POST['featured_post'] ) && $_POST['featured_post'] ) ? '1' : '2';
		update_post_meta( $post_id, 'featured_post', $chk );
		
		// Add values of $events_meta as custom fields
		foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!
			if( $post->post_type == 'post' ) return; // Don't store custom data twice
			$value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
			if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
				update_post_meta($post->ID, $key, $value);
			} else { // If the custom field doesn't have a value
				add_post_meta($post->ID, $key, $value);
			}
			if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
		}

	}
	/* End */
/*Make it Featured*/

	// Post Time box
	add_action( 'add_meta_boxes', 'post_time' );
	function post_time() {
	    add_meta_box( 
	        'post_time',
	        esc_html__( 'Duration', 'betube' ),
	        'post_time_content',
	        'post',
	        'normal',
	        'high'
	    );
	}

	function post_time_content( $post ) {
		wp_nonce_field( 'myplugin_meta_boxeee', 'myplugin_meta_box_nonceeee' );
		$post_time = get_post_meta( $post->ID, 'post_time', true );

		echo '<label for="post_time"></label>';
		echo '<input type="text" id="post_time" name="post_time" placeholder="Enter Time here" value="';
		echo $post_time; 
		echo '">';
		
	}

	add_action( 'save_post', 'post_time_save' );
	function post_time_save( $post_id ) {		

		global $post_time;
		
		if ( ! isset( $_POST['myplugin_meta_box_nonceeee'] ) ) {
		return;
		}
		if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonceeee'], 'myplugin_meta_boxeee' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if(isset($_POST["post_time"]))
		$post_time = $_POST['post_time'];
		update_post_meta( $post_id, 'post_time', $post_time );

	}

	// Post Quality box
	add_action( 'add_meta_boxes', 'post_quality' );
	function post_quality() {
	    add_meta_box( 
	        'post_quality',
	        esc_html__( 'Quality', 'betube' ),
	        'post_quality_content',
	        'post',
	        'normal',
	        'high'
	    );
	}

	function post_quality_content( $post ) {
		wp_nonce_field( 'myplugin_meta_boxee', 'myplugin_meta_box_nonceee' );
		$post_quality = get_post_meta( $post->ID, 'post_quality', true );

		echo '<label for="post_quality"></label>';
		echo '<input type="text" id="post_quality" name="post_quality" placeholder="HD, 720p, 320p" value="';
		echo $post_quality; 
		echo '">';
		
	}

	add_action( 'save_post', 'post_quality_save' );
	function post_quality_save( $post_id ) {				
		global $post_quality;
		if ( ! isset( $_POST['myplugin_meta_box_nonceee'] ) ) {
		return;
		}
		if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonceee'], 'myplugin_meta_boxee' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if(isset($_POST["post_quality"]))
		$post_quality = $_POST['post_quality'];
		update_post_meta( $post_id, 'post_quality', $post_quality );

	}
	/*Post video link */	
	add_action( 'add_meta_boxes', 'video_link' );
	function video_link() {
	    add_meta_box( 
	        'video_link',
	        esc_html__( 'Video Link', 'betube' ),
	        'video_link_content',
	        'post',
	        'normal',
	        'high'
	    );
	}

	function video_link_content( $post ) {
		wp_nonce_field( 'myplugin_meta_boxeee', 'myplugin_meta_box_nonceeee' );
		$video_link = get_post_meta( $post->ID, 'jtheme_video_url', true );
		
		echo '<textarea name="video_link" id="video_link" cols="94">'.$video_link.'</textarea>';
		
	}

	add_action( 'save_post', 'video_link_save' );
	function video_link_save( $post_id ) {		

		global $video_link;
		
		if ( ! isset( $_POST['myplugin_meta_box_nonceeee'] ) ) {
		return;
		}
		if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonceeee'], 'myplugin_meta_boxeee' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if(isset($_POST["video_link"]))
		$video_link = $_POST['video_link'];
		update_post_meta( $post_id, 'jtheme_video_url', $video_link );

	}
	/*End Post video link */
	/*Post video second link */
	add_action( 'add_meta_boxes', 'single_video_link_second' );
	function single_video_link_second() {
	    add_meta_box( 
	        'single_video_link_second',
	        esc_html__( 'Second Video Link', 'betube' ),
	        'single_video_link_second_content',
	        'post',
	        'normal',
	        'high'
	    );
	}

	function single_video_link_second_content( $post ) {
		wp_nonce_field( 'myplugin_meta_boxeee', 'myplugin_meta_box_nonceeee' );
		$single_video_link_second = get_post_meta( $post->ID, 'single_video_link_second', true );
		
		echo '<textarea name="single_video_link_second" id="single_video_link_second" cols="94">'.$single_video_link_second.'</textarea>';
		
	}

	add_action( 'save_post', 'single_video_link_second_save' );
	function single_video_link_second_save( $post_id ) {		

		global $single_video_link_second;
		
		if ( ! isset( $_POST['myplugin_meta_box_nonceeee'] ) ) {
		return;
		}
		if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonceeee'], 'myplugin_meta_boxeee' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if(isset($_POST["single_video_link_second"]))
		$single_video_link_second = $_POST['single_video_link_second'];
		update_post_meta( $post_id, 'single_video_link_second', $single_video_link_second );

	}
	/*End Post video second link */	
	/*Post video third link */
	add_action( 'add_meta_boxes', 'single_video_link_third' );
	function single_video_link_third() {
	    add_meta_box( 
	        'single_video_link_third',
	        esc_html__( 'Third Video Link', 'betube' ),
	        'single_video_link_third_content',
	        'post',
	        'normal',
	        'high'
	    );
	}

	function single_video_link_third_content( $post ) {
		wp_nonce_field( 'myplugin_meta_boxeee', 'myplugin_meta_box_nonceeee' );
		$single_video_link_third = get_post_meta( $post->ID, 'single_video_link_third', true );
		
		echo '<textarea name="single_video_link_third" id="single_video_link_third" cols="94">'.$single_video_link_third.'</textarea>';
		
	}

	add_action( 'save_post', 'single_video_link_third_save' );
	function single_video_link_third_save( $post_id ) {		

		global $single_video_link_third;
		
		if ( ! isset( $_POST['myplugin_meta_box_nonceeee'] ) ) {
		return;
		}
		if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonceeee'], 'myplugin_meta_boxeee' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if(isset($_POST["single_video_link_third"]))
		$single_video_link_third = $_POST['single_video_link_third'];
		update_post_meta( $post_id, 'single_video_link_third', $single_video_link_third );

	}
	/*End Post video third link */
	/*Post Embed Code*/		
	add_action( 'add_meta_boxes', 'jtheme_video_code' );
	function jtheme_video_code() {
	    add_meta_box( 
	        'jtheme_video_code',
	        esc_html__( 'Video Code', 'betube' ),
	        'jtheme_video_code_content',
	        'post',
	        'normal',
	        'high'
	    );
	}

	function jtheme_video_code_content( $post ) {
		wp_nonce_field( 'myplugin_meta_boxeee', 'myplugin_meta_box_nonceeee' );
		$jtheme_video_code = get_post_meta( $post->ID, 'jtheme_video_code', true );
		
		echo '<textarea name="jtheme_video_code" id="jtheme_video_code" cols="94">'.$jtheme_video_code.'</textarea>';		 
		
		
	}

	add_action( 'save_post', 'jtheme_video_code_save' );
	function jtheme_video_code_save( $post_id ) {		

		global $jtheme_video_code;
		
		if ( ! isset( $_POST['myplugin_meta_box_nonceeee'] ) ) {
		return;
		}
		if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonceeee'], 'myplugin_meta_boxeee' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if(isset($_POST["jtheme_video_code"]))
		$jtheme_video_code = $_POST['jtheme_video_code'];
		update_post_meta( $post_id, 'jtheme_video_code', $jtheme_video_code );

	}
	/* End Post Embed Code*/
	/*Custom Video Link*/		
	add_action( 'add_meta_boxes', 'jtheme_video_file' );
	function jtheme_video_file() {
	    add_meta_box( 
	        'jtheme_video_file',
	        esc_html__( 'Video File URL', 'betube' ),
	        'jtheme_video_file_content',
	        'post',
	        'normal',
	        'high'
	    );
	}

	function jtheme_video_file_content( $post ) {
		wp_nonce_field( 'myplugin_meta_boxeee', 'myplugin_meta_box_nonceeee' );
		$jtheme_video_file = get_post_meta( $post->ID, 'jtheme_video_file', true );
		
		echo '<textarea name="jtheme_video_file" id="jtheme_video_file" cols="94">'.$jtheme_video_file.'</textarea>';		 
		
		
	}

	add_action( 'save_post', 'jtheme_video_file_save' );
	function jtheme_video_file_save( $post_id ) {		

		global $jtheme_video_file;
		
		if ( ! isset( $_POST['myplugin_meta_box_nonceeee'] ) ) {
		return;
		}
		if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonceeee'], 'myplugin_meta_boxeee' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if(isset($_POST["jtheme_video_file"]))
		$jtheme_video_file = $_POST['jtheme_video_file'];
		update_post_meta( $post_id, 'jtheme_video_file', $jtheme_video_file );

	}
	/* Custom Video Link*/
	/*PostViews*/			
	add_action( 'add_meta_boxes', 'betube_fake_views' );
	function betube_fake_views() {
	    add_meta_box( 
	        'betube_fake_views',
	        esc_html__( 'Fake Views', 'betube' ),
	        'betube_fake_views_content',
	        'post',
	        'normal',
	        'high'
	    );
	}

	function betube_fake_views_content( $post ) {
		wp_nonce_field( 'fakeview_meta_boxeee', 'fakeviews_meta_box_nonceeee' );
		$betubeFakeViews = get_post_meta( $post->ID, 'wpb_post_views_count', true );
		
		echo '<label for="post_fake_views"></label>';
		echo '<input type="text" id="post_fake_views" name="wpb_post_views_count" value="';
		echo $betubeFakeViews; 
		echo '">';			
	}

	add_action( 'save_post', 'betube_fake_views_save' );
	function betube_fake_views_save( $post_id ) {		

		global $betubeFakeViews;
		
		if ( ! isset( $_POST['fakeviews_meta_box_nonceeee'] ) ) {
		return;
		}
		if ( ! wp_verify_nonce( $_POST['fakeviews_meta_box_nonceeee'], 'fakeview_meta_boxeee' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if(isset($_POST["wpb_post_views_count"]))
		$betubeFakeViews = $_POST['wpb_post_views_count'];
		update_post_meta( $post_id, 'wpb_post_views_count', $betubeFakeViews );

	}	
	/*PostViews*/
	/*PostLikes*/
	add_action( 'add_meta_boxes', 'betube_fake_likes' );
	function betube_fake_likes() {
	    add_meta_box( 
	        'betube_fake_likes',
	        esc_html__( 'Fake Likes', 'betube' ),
	        'betube_fake_likes_content',
	        'post',
	        'normal',
	        'high'
	    );
	}

	function betube_fake_likes_content( $post ) {
		wp_nonce_field( 'fakelikes_meta_boxeee', 'fakelikes_meta_box_nonceeee' );
		$betubeFakeLikes = get_post_meta( $post->ID, '_post_like_count', true );
		
		echo '<label for="post_fake_likes"></label>';
		echo '<input type="text" id="post_fake_likes" name="betube_like_count" value="';
		echo $betubeFakeLikes; 
		echo '">';			
	}

	add_action( 'save_post', 'betube_fake_likes_save' );
	function betube_fake_likes_save( $post_id ) {		

		global $betubeFakeLikes;
		
		if ( ! isset( $_POST['fakelikes_meta_box_nonceeee'] ) ) {
		return;
		}
		if ( ! wp_verify_nonce( $_POST['fakelikes_meta_box_nonceeee'], 'fakelikes_meta_boxeee' ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if(isset($_POST["betube_like_count"]))
		$betubeFakeLikes = $_POST['betube_like_count'];
		update_post_meta( $post_id, '_post_like_count', $betubeFakeLikes );

	}	
	/*PostLikes*/
?>
