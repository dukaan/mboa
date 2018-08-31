<?php
/*Start BeTube Email Functions*/	
/* Publish Post Email Function*/
global $redux_demo;
$betubePublishPost = $redux_demo['betube-publish-post-notification'];
if($betubePublishPost == 1){
	add_action("publish_post", "betubePostEmail");
	function betubePostEmail($post_id) {
		$post = get_post($post_id);
		$author = get_userdata($post->post_author);
		global $redux_demo;
		$logo = $redux_demo['betube-logo']['url'];
		
		$author_email = $author->user_email;
		$email_subject = "Your Listing has been published!";
		
		ob_start();		
		
		include(get_template_directory() . '/templates/email/email-header.php');
		
		?>
		<p>
			<?php if (!empty($logo)) { ?>
			<img src="<?php echo $logo; ?>" alt="Logo" />
			<?php } else { ?>
			<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Logo" />
			<?php } ?>
		</p>
		<p>
			<?php esc_html_e( 'Hi', 'betube' ); ?>, <?php echo $author->display_name ?>. <?php esc_html_e( 'Congratulations your item has been listed', 'betube' ); ?>! 
			<strong>(<?php echo $post->post_title ?>)</strong> <?php esc_html_e( 'on', 'betube' ); ?> <?php echo  $blog_title = get_bloginfo('name'); ?>!
		</p>
		<p><?php esc_html_e( 'You have successfully listed your item on', 'betube' ); ?> <strong><?php echo  $blog_title = get_bloginfo('name'); ?></strong>, <?php esc_html_e( 'now sit back and let us do the hard work.', 'betube' ); ?></p>
		<p>
			<?php esc_html_e( 'If youd like to take a look', 'betube' ); ?>, <a href="<?php echo get_permalink($post->ID) ?>"><?php esc_html_e( 'Click Here', 'betube' ); ?></a>.
			
		</p>
		
		
		<?php
		
		include(get_template_directory() . '/templates/email/email-footer.php');
		
		
		$message = ob_get_contents();
		
		ob_end_clean();	
		
		wp_mail($author_email, $email_subject, $message);
		
	}
}	
/* Publish Post Email Function End*/
/* New User Registration Function Start*/

function beTubeUserNotification($email, $password, $username) {	

	$blog_title = get_bloginfo('name');
	$blog_url = esc_url( home_url() ) ;
	$adminEmail =  get_bloginfo('admin_email');
	global $redux_demo;
	$logo = $redux_demo['betube-logo']['url'];
	
	$email_subject = "Welcome to ".$blog_title." ".$username."!";
	
	ob_start();	
	include(get_template_directory() . '/templates/email/email-header.php');
	
	?>
	<p>
		<?php if (!empty($logo)) { ?>
		<img src="<?php echo $logo; ?>" alt="Logo" />
		<?php } else { ?>
		<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Logo" />
		<?php } ?>
	</p>
	<p><?php esc_html_e( 'A very special welcome to you', 'betube' ); ?>, <?php echo $username ?>. <?php esc_html_e( 'Thank you for joining', 'betube' ); ?> <?php echo $blog_title; ?>!</p>
	<p>
		<?php esc_html_e( 'Your username is', 'betube' ); ?> <strong style="color:orange"><?php echo $username ?></strong> <br>		
	</p>
	<p>
		<?php esc_html_e( 'Your password is', 'betube' ); ?> <strong style="color:orange"><?php echo $password ?></strong> <br>
		<?php esc_html_e( 'Please keep it secret and keep it safe!', 'betube' ); ?>
	</p>
	
	<p>
		<?php esc_html_e( 'We hope you enjoy your stay at', 'betube' ); ?> <a href="<?php echo $blog_url; ?>"><?php echo $blog_title; ?></a>. <?php esc_html_e( 'If you have any problems, questions, opinions, praise, comments, suggestions, please feel free to contact us at', 'betube' ); ?> 
		 <strong><?php echo $adminEmail; ?> </strong><?php esc_html_e( 'any time!', 'betube' ); ?>
	</p>
	
	
	<?php
	
	include(get_template_directory() . '/templates/email/email-footer.php');
	
	$message = ob_get_contents();
	ob_end_clean();

	wp_mail($email, $email_subject, $message);
	}

/* New User Registration Function End*/
/* Email to Admin On New User Registration */
function beTubeNewUserNotifiy($email, $username) {	

	$blog_title = get_bloginfo('name');
	$blog_url = esc_url( home_url() ) ;
	$adminEmail =  get_bloginfo('admin_email');
	global $redux_demo;
	$logo = $redux_demo['betube-logo']['url'];
	
	$email_subject = "New User Has been Registered On ".$blog_title;
	
	ob_start();	
	include(get_template_directory() . '/templates/email/email-header.php');
	
	?>
	<p>
		<?php if (!empty($logo)) { ?>
		<img src="<?php echo $logo; ?>" alt="Logo" />
		<?php } else { ?>
		<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Logo" />
		<?php } ?>
	</p>
	<p><?php esc_html_e( 'Hello, New User has been Registred on', 'betube' ); ?>, <?php echo $blog_title ?>. <?php esc_html_e( 'By using this email', 'betube' ); ?> <?php echo $email; ?>!</p>
	<p>
		<?php esc_html_e( 'His User name is:', 'betube' ); ?> <strong style="color:orange"><?php echo $username ?></strong> <br>		
	</p>
	<?php
	
	include(get_template_directory() . '/templates/email/email-footer.php');
	
	$message = ob_get_contents();
	ob_end_clean();

	wp_mail($adminEmail, $email_subject, $message);
	}
/* Email to Admin On New User Registration */
/*Pending Post Status Function*/
function betubePendingPost( $new_status, $old_status, $post ) {
    if ( $new_status == 'private' ) {
        $author = get_userdata($post->post_author);
		global $redux_demo;
		$logo = $redux_demo['betube-logo']['url'];
		$adminEmail =  get_bloginfo('admin_email');
		$email_subject = "New Post Has been Posted";
		
		ob_start();
		include(get_template_directory() . '/templates/email/email-header.php');
		?>
			<p>
				<?php if (!empty($logo)) { ?>
				<img src="<?php echo $logo; ?>" alt="Logo" />
				<?php } else { ?>
				<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Logo" />
				<?php } ?>
			</p>
			<p>
				<?php esc_html_e( 'Hi', 'betube' ); ?>, <?php echo $author->display_name ?>. <?php esc_html_e( 'Have Post New Ads', 'betube' ); ?><strong>(<?php echo $post->post_title ?>)</strong> <?php esc_html_e( 'on', 'betube' ); ?> <?php echo  $blog_title = get_bloginfo('name'); ?>!
			</p>
			<p><?php esc_html_e( 'Please Approve or Reject this Post from WordPress Dashboard.', 'betube' ); ?></p>
		<?php
		include(get_template_directory() . '/templates/email/email-footer.php');
		$message = ob_get_contents();
		ob_end_clean();
		wp_mail($adminEmail, $email_subject, $message);
    }
}
add_action(  'transition_post_status',  'betubePendingPost', 10, 3 );
/*Pending Post Status Function End*/
/*Email to Post Author */
function contactToAuthor($emailTo, $subject, $name, $email, $comments, $headers) {	

	$blog_title = get_bloginfo('name');
	$blog_url = esc_url( home_url() ) ;
	$adminEmail =  get_bloginfo('admin_email');
	global $redux_demo;
	$logo = $redux_demo['betube-logo']['url'];
	
	$email_subject = $subject;
	
	ob_start();	
	include(get_template_directory() . '/templates/email/email-header.php');
	
	?>
	<p>
		<?php if (!empty($logo)) { ?>
		<img src="<?php echo $logo; ?>" alt="Logo" />
		<?php } else { ?>
		<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Logo" />
		<?php } ?>
	</p>
	<p><?php echo $comments; ?></p>
	<p><?php esc_html_e( 'Your have received this email from', 'betube' ); ?></p>
	<p><strong><?php esc_html_e( 'Sender Name', 'betube' ); ?></strong>:&nbsp;<?php echo  $name;?></p>
	<p><strong><?php esc_html_e( 'Sender Email', 'betube' ); ?></strong>:&nbsp;<?php echo  $email;?></p>
	
	<?php
	
	include(get_template_directory() . '/templates/email/email-footer.php');
	
	$message = ob_get_contents();
	ob_end_clean();

	wp_mail($emailTo, $email_subject, $message, $headers);
	}
/* Email Function End*/