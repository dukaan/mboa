<?php
/**
 * Template name: Reset Password Page
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage betube
 * @since betube 1.0
 */

if ( is_user_logged_in() ) { 

	global $redux_demo; 
	$profile = $redux_demo['profile'];
	wp_redirect( $profile ); exit;

}

global $resetSuccess;

if (!$user_ID) {

	if($_POST['submit'] == 'Reset') 

	{

		// First, make sure the email address is set
		if ( isset( $_POST['email'] ) && ! empty( $_POST['email'] ) ) {

		  	// Next, sanitize the data
		  	$email_addr = trim( strip_tags( stripslashes( $_POST['email'] ) ) );

		  	$user = get_user_by( 'email', $email_addr );			
		  	$user_ID = $user->ID;
			$userName = $user->user_login;

		  	if( !empty($user_ID)) {

				$new_password = wp_generate_password( 12, false ); 

				if ( isset($new_password) ) {

					wp_set_password( $new_password, $user_ID );
					$message = esc_html__( 'Check your email for new password', 'betube' );

			      	$from = get_option('admin_email');
					$headers = 'From: '.$from . "\r\n";
					$subject = "Password reset!";
					$msg = "Your New Password is: $new_password and your user name is:$userName";
					wp_mail( $email_addr, $subject, $msg, $headers );

					$resetSuccess = 1;

				}

		    } else {
		      	$message = esc_html__( 'There is no user available for this email', 'betube' );
		    } // end if/else

		} else {
			$message = esc_html__( 'Email should not be empty.', 'betube' );
		}

	}

}

get_header(); 
betube_breadcrumbs();
?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
?>
<section class="registration">
	<div class="row secBg">
		<div class="large-12 columns">
			<div class="login-register-content">
				<div class="row collapse borderBottom">
					<div class="medium-6 large-centered medium-centered">
						<div class="page-heading text-center">
							<h3><?php esc_html_e('Reset Your Password', 'betube') ?></h3>
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<?php the_content(); ?>
							<?php endwhile; endif; ?>
						</div>
					</div><!--medium-6-->
				</div><!--Row-->
				<div class="row" data-equalizer data-equalize-on="medium" id="test-eq">
					<div class="large-4 medium-6 large-centered medium-centered columns">
						<div class="register-form">
							<?php if($resetSuccess == 1) {}else{?>
							<h5 class="text-center"><?php esc_html_e('Enter Email', 'betube') ?></h5>
							<?php }?>
							<form method="post" action="" id="myform" method="POST" enctype="multipart/form-data" data-abide novalidate>
								<?php if($_POST) { ?>
								<span><?php esc_html_e( 'Go to your inbox or spam/junk and get your password', 'betube' ); ?></span>
								<?php }?>
								<?php if($resetSuccess == 1) {}else{?>
								<div class="input-group">
									<span class="input-group-label"><i class="fa fa-user"></i></span>
									<input type="email" name="email" id="email" placeholder="<?php esc_html_e('Enter your email...', 'betube') ?>" required>
									<span class="form-error"><?php esc_html_e('Email is required', 'betube') ?></span>
								</div>
								<input type="hidden" id="submit" name="submit" value="Reset" />
								<button class="button expanded" type="submit" name="op" value="Reset"><?php esc_html_e('Reset Now', 'betube') ?></button>
								<?php }?>
							</form>
						</div><!--register-form-->
					</div><!--large4-->
				</div><!--inner row-->
			</div><!--login-register-content-->
		</div><!--Large12-->
	</div><!--Row-->
</section><!--Main Section-->
<?php get_footer(); ?>