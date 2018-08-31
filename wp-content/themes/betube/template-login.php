<?php
/**
 * Template name: Login Page
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage betube
 * @since betube
 */

if ( is_user_logged_in() ) { 

	global $redux_demo; 
	$profile = $redux_demo['profile'];
	wp_redirect( $profile ); exit;

}

global $user_ID, $username, $password, $remember;

//We shall SQL escape all inputs
$username = esc_sql(isset($_REQUEST['username']) ? $_REQUEST['username'] : '');
$password = esc_sql(isset($_REQUEST['password']) ? $_REQUEST['password'] : '');
$remember = esc_sql(isset($_REQUEST['rememberme']) ? $_REQUEST['rememberme'] : '');
	
if($remember) $remember = "true";
else $remember = "false";
$login_data = array();
$login_data['user_login'] = $username;
$login_data['user_password'] = $password;
$login_data['remember'] = $remember;
$user_verify = wp_signon( $login_data, false ); 
//wp_signon is a wordpress function which authenticates a user. It accepts user info parameters as an array.

if(isset($_POST['submit'])){	
	if($_POST['submit'] == 'Login'){
		
		$login_data = array();
		$login_data['user_login'] = $username;
		$login_data['user_password'] = $password;
		$login_data['remember'] = $remember;
		$user_verify = wp_signon( $login_data, false ); 
		//print_r($user_verify); exit();
		if( is_wp_error($user_verify)){			
			$UserError = esc_html__( 'Invalid username or password. Please try again!', 'betube' );
		}else{

			global $redux_demo; 
			$profile = $redux_demo['profile'];
			wp_redirect( $profile ); exit;

		}
	}
}

get_header(); 
//betube_breadcrumbs();
?>
<!-- advertisement -->
<?php global $redux_demo;
?>
<section class="registration">
	<div class="row secBg">
		<div class="large-12 columns">
			<div class="login-register-content">
				<div class="row collapse borderBottom">
					<div class="medium-6 large-centered medium-centered">
						<div class="page-heading text-center">
							<h3><?php esc_html_e('User login', 'betube') ?></h3>
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<?php the_content(); ?>
							<?php endwhile; endif; ?>
						</div><!--page-heading-->
					</div><!--medium-6-->
				</div><!--row collapse-->
				<div class="row" data-equalizer data-equalize-on="medium" id="test-eq">
					<div class="large-4 large-offset-1 medium-6 columns">
						<div class="social-login" data-equalizer-watch>
							<h5 class="text-center"><?php esc_html_e('Login via Social Profile', 'betube') ?></h5>
							
							<?php
							/* Detect plugin. For use on Front End only.*/
							include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
							// check for plugin using plugin name
							if ( is_plugin_active( "nextend-facebook-connect/nextend-facebook-connect.php" ) ) {
								//plugin is activated
							?>
							<div class="social-login-btn facebook">								
								<a class="loginSocialbtn fb" href="<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;"><i class="fa fa-facebook"></i><?php esc_html_e('Login via Facebook', 'betube') ?></a>
							</div>
							<?php } ?>
							
							<?php
							/* Detect plugin. For use on Front End only.*/
							include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
							// check for plugin using plugin name
							if ( is_plugin_active( "nextend-twitter-connect/nextend-twitter-connect.php" ) ) {
								//plugin is activated
							?>
							<div class="social-login-btn twitter">
								<a class="loginSocialbtn twitter" href="<?php echo get_site_url(); ?>/wp-login.php?loginTwitter=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginTwitter=1&redirect='+window.location.href; return false;"><i class="fa fa-twitter"></i><?php esc_html_e('Login via Twitter', 'betube') ?></a>
							</div>
							<?php } ?>
							
							<?php
							/* Detect plugin. For use on Front End only.*/
							include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
							// check for plugin using plugin name
							if ( is_plugin_active( "nextend-google-connect/nextend-google-connect.php" ) ) {
								//plugin is activated
							?>
							<div class="social-login-btn g-plus">
								<a class="loginSocialbtn google" href="<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1" onclick="window.location = '<?php echo get_site_url(); ?>/wp-login.php?loginGoogle=1&redirect='+window.location.href; return false;"><i class="fa fa-google-plus"></i><?php esc_html_e('Login via Google', 'betube') ?></a>
							</div>
							<?php } ?>
							<!--AccessPress Socil Login-->
							<?php
							include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
							if ( is_plugin_active( "accesspress-social-login-lite/accesspress-social-login-lite.php" )){
								?>
								<div class="betubeAPSL">
								<?php echo do_shortcode('[apsl-login-lite]'); ?>
								</div>
								<?php
							}
							if ( is_plugin_active( "accesspress-social-login/accesspress-social-login.php" )){
								?>
								<div class="betubeAPSL">
								<?php echo do_shortcode('[apsl-login]'); ?>
								</div>
								<?php
							}
							?>
							<!--AccessPress Socil Login-->
						</div><!--social-login-->
					</div><!--large-4-->
					<div class="large-2 medium-2 columns show-for-large">
						<div class="middle-text text-center hide-for-small-only" data-equalizer-watch>
							<p>
								<i class="fa fa-arrow-left arrow-left"></i>
								<span><?php esc_html_e('OR', 'betube') ?></span>
								<i class="fa fa-arrow-right arrow-right"></i>
							</p>
						</div><!--middle-text-->
					</div><!--large-2-->
					<div class="large-4 medium-6 columns end">
						<div class="register-form">
							<h5 class="text-center"><?php esc_html_e('Login Here...', 'betube') ?></h5>
							<form id="myform" method="POST" enctype="multipart/form-data" data-abide novalidate>
								<div data-abide-error class="alert callout" style="display: none;">
									<p><i class="fa fa-exclamation-triangle"></i>
									<?php esc_html_e('There are some errors in your form.', 'betube') ?>																	
									</p>
								</div>
								<?php if(!empty($UserError)) { ?>
								<div>
									<p>
										<i class="fa fa-exclamation-triangle"></i>
										<?php echo $UserError; ?>										
									</p>
								</div>
								<?php } ?>	
								<div class="input-group">
									<span class="input-group-label"><i class="fa fa-user"></i></span>
									<input class="input-group-field" type="text" id="contactName" name="username" placeholder="<?php esc_html_e('Enter your username', 'betube') ?>" required>
									<span class="form-error"><?php esc_html_e('username is required', 'betube') ?></span>
								</div><!--input-group UserName-->
								<div class="input-group">
									<span class="input-group-label"><i class="fa fa-lock"></i></span>
									<input type="password" id="password" name="password" placeholder="<?php esc_html_e('Enter your Password', 'betube') ?>" required>
									<span class="form-error"><?php esc_html_e('Password is required', 'betube') ?></span>
								</div><!--input-group password-->
								<div class="checkbox">
									<input id="remember" type="checkbox" value="forever" name="rememberme">
									<label class="customLabel" for="remember"><?php esc_html_e( 'Remember me', 'betube' ); ?></label>
								</div>
								<input type="hidden" id="submitbtn" name="submit" value="Login" />
								<button class="button expanded" type="submit" name="op" value="Login"><?php esc_html_e('LOGIN NOW', 'betube') ?></button>
								<?php 
								global $redux_demo;
								$reset = $redux_demo['reset'];
								$register = $redux_demo['register'];
								?>
								<p class="loginclick"><a href="<?php echo $reset; ?>"><?php esc_html_e('Forget Password?', 'betube') ?></a> <?php esc_html_e('New Here?', 'betube') ?>&nbsp;<a href="<?php echo $register; ?>"><?php esc_html_e('Create a new Account', 'betube') ?></a></p>
							</form>
						</div><!--register-form-->
					</div><!--large-4 Login Form-->
				</div><!--row-->
			</div><!--login-register-content-->
		</div><!--large-12-->
	</div><!--row secBg-->
</section><!--Section-->
<?php get_footer(); ?>