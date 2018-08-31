<?php
/**
 * Template name: Edit Profile
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage betube
 * @since betube 1.0
 */

if ( !is_user_logged_in() ) { 

	global $redux_demo; 
	$login = $redux_demo['login'];
	wp_redirect( $login ); exit;

}



global $user_ID, $user_identity, $user_level;
global $redux_demo;
$profile = $redux_demo['profile'];


if ($user_ID) {

	if($_POST){		
		$message = esc_html__( 'Your profile updated successfully.', 'betube' );
		global $wpdb;
		$firstName = $wpdb->escape($_POST['first_name']);
		$lastName = $wpdb->escape($_POST['last_name']);
		$nickName = $wpdb->escape($_POST['user_nicename']);
		$displayName = $wpdb->escape($_POST['display_name']);
		
		$firsttext = $wpdb->escape($_POST['betube_heading_one']);
		$secondtext = $wpdb->escape($_POST['betube_heading_second']);

		$email = $wpdb->escape($_POST['email']);
		$user_url = $wpdb->escape($_POST['website']);
		$user_phone = $wpdb->escape($_POST['phone']);
		
		
		$facebook = $wpdb->escape($_POST['facebook']);
		$twitter = $wpdb->escape($_POST['twitter']);
		$googleplus = $wpdb->escape($_POST['google-plus']);
		$youtube = $wpdb->escape($_POST['youtube']);
		$vimeo = $wpdb->escape($_POST['vimeo']);
		$pinterest = $wpdb->escape($_POST['pinterest']);
		$instagram = $wpdb->escape($_POST['instagram']);
		$linkedin = $wpdb->escape($_POST['linkedin']);

		$description = $wpdb->escape($_POST['desc']);

		$password = $wpdb->escape($_POST['pwd']);
		

		$newPassword = $wpdb->escape($_POST['confirm']);

		update_user_meta( $user_ID, 'first_name', $firstName );
		update_user_meta( $user_ID, 'last_name', $lastName );
		update_user_meta( $user_ID, 'user_nicename', $nickName );
		update_user_meta( $user_ID, 'firsttext', $firsttext );
		update_user_meta( $user_ID, 'display_name', $displayName );
		update_user_meta( $user_ID, 'secondtext', $secondtext );
		update_user_meta( $user_ID, 'phone', $user_phone );		
		
		update_user_meta( $user_ID, 'facebook', $facebook );
		update_user_meta( $user_ID, 'twitter', $twitter );
		update_user_meta( $user_ID, 'googleplus', $googleplus );
		update_user_meta( $user_ID, 'youtube', $youtube );
		update_user_meta( $user_ID, 'vimeo', $vimeo );
		update_user_meta( $user_ID, 'linkedin', $linkedin );
		update_user_meta( $user_ID, 'pinterest', $pinterest );
		update_user_meta( $user_ID, 'instagram', $instagram );

		update_user_meta( $user_ID, 'description', $description );

		wp_update_user( array ('ID' => $user_ID, 'user_url' => $user_url) );		

		if(isset($email)) {

			if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email)){ 

				wp_update_user( array ('ID' => $user_ID, 'user_email' => $email) ) ;

			}

			else { 
			
				$message = '<div id="error">' . esc_html__( 'Please enter a valid email id.', 'betube' ) . '</div>';
			}

		}

		if(isset($password) && !empty($newPassword)) {			

			if (strlen($password) < 5 || strlen($password) > 25) {
				
				$message = '<div id="error">' . esc_html__( 'Password must be 5 to 15 characters in length.', 'betube' ) . '</div>';

				}

			
			if(isset($newPassword) && $newPassword == $password) {

				$message = '<div id="error">' . esc_html__( 'You are using Old Password for update, Please use new Password.', 'betube' ) . '</div>';

			} elseif ( isset($newPassword) && !empty($password) ) {

				$update = wp_set_password( $newPassword, $user_ID );				
				
				$message = '<div id="success">' . esc_html__( 'Your Profile is Updated Successfully!', 'betube' ) . '</div>';

			}

		}
	}	
	/*ImageUploading*/
	if ( isset($_FILES['upload_attachment']) || isset($_FILES['upload_profile'])){
		$files = $_FILES['upload_attachment'];
		$profile = $_FILES['upload_profile'];			
		//Update Profile background//
		foreach ($files['name'] as $key => $value) {				
			if ($files['name'][$key]) {
				$file = array(
					'name'     => $files['name'][$key],
					'type'     => $files['type'][$key],
					'tmp_name' => $files['tmp_name'][$key],
					'error'    => $files['error'][$key],
					'size'     => $files['size'][$key]
				);
				$_FILES = array("upload_attachment" => $file);				
				foreach($_FILES as $file => $array){					
					$newupload = betube_insert_userIMG($file);										
					if(!empty($newupload )){
						update_user_meta( $user_ID, 'betube_author_profile_bg', $newupload );
					}
				}
			}
		}
		//Update Profile background//		
		//Update Profile IMG
		foreach ($profile['name'] as $key => $value) {				
			if ($profile['name'][$key]) {
				$file = array(
					'name'     => $profile['name'][$key],
					'type'     => $profile['type'][$key],
					'tmp_name' => $profile['tmp_name'][$key],
					'error'    => $profile['error'][$key],
					'size'     => $profile['size'][$key]
				);
				$_FILES = array("upload_profile" => $file);				
				foreach($_FILES as $file => $array){					
					$profileAva = betube_insert_userIMG($file);
					if(!empty($profileAva )){
						update_user_meta( $user_ID, 'betube_author_avatar_url', $profileAva );
					}					
				}
			}
		}		
		//Update Profile IMG
	}
}
get_header();
betube_breadcrumbs();
?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$betubeProfileIMG = get_user_meta($user_ID, "betube_author_profile_bg", true);
	if(!empty($betubeProfileIMG)){
		$betubeProfileIMG = betube_get_image_url($betubeProfileIMG);
	}
?>	
<?php while ( have_posts() ) : the_post(); ?>
<form class="form-item" action="" id="primaryPostForm" method="POST" enctype="multipart/form-data">
<section class="topProfile topProfile-inner" style="background: url('<?php echo $betubeProfileIMG; ?>') no-repeat;">
	<div class="row">
		<div class="large-12 columns">
			<div class="upload-bg">			
				<label for="topfileupload" class="btn-upload"><i class="fa fa-camera"></i><span><?php esc_html_e("update cover image", 'betube') ?></span></label>
				<input type="file" id="topfileupload" class="uploadauthorBG show-for-sr" name="upload_attachment[]">
			</div><!--upload-bg-->
		</div><!--large-12-->
	</div><!--Row upload cover-->
	<div class="main-text">
		<div class="row">
			<div class="large-12 columns">
				<?php 
				$betubeFirstTXT = get_the_author_meta('firsttext', $user_ID);
				$betubesecondTXT = get_the_author_meta('secondtext', $user_ID);
				if(!empty($betubeFirstTXT)){	
				?>
				<h3><?php echo $betubeFirstTXT; ?></h3>
				<?php } ?>
				<?php if(!empty($betubesecondTXT)){?>
				<h1><?php echo $betubesecondTXT; ?></h1>
				<?php } ?>
			</div><!--large-12-->
		</div>
	</div><!--main-text-->
	<div class="profile-stats">
		<div class="row secBg">
			<div class="large-12 columns">
				<div class="profile-author-img">
				<?php 				
				$author_avatar_url = get_user_meta($user_ID, "betube_author_avatar_url", true);
				if(!empty($author_avatar_url)) {
					$author_avatar_url = betube_get_image_url($author_avatar_url);
					?>
					<img class="author-avatar" src="<?php echo $author_avatar_url; ?>" alt="" />
					<?php
				}else{
					$avatar_url = betube_get_avatar_url ( get_the_author_meta('user_email', $user_ID), $size = '130' );
					?>
					<img class="author-avatar" src="<?php echo $avatar_url; ?>" alt="" />
					<?php
				}
				?>				
					
				<label for="imgfileupload" class="btn-upload"><i class="fa fa-camera"></i><span class=""><?php esc_html_e("update Avatar", 'betube') ?></span></label>
				<input type="file" id="imgfileupload" class="upload-author-image show-for-sr" name="upload_profile[]">
				</div><!--profile-author-img-->
				<div class="profile-subscribe">
					<span><i class="fa fa-users"></i><?php echo betubeFollowerCount($user_ID);?></span>
					<button type="submit" name="subscribe"><?php esc_html_e("subscribe", 'betube') ?></button>
				</div><!--profile-subscribe-->
				<div class="profile-share">
					<div class="easy-share" data-easyshare data-easyshare-http data-easyshare-url="<?php echo esc_url( home_url( '/' ) ); ?>">
						<!-- Facebook -->
						<button data-easyshare-button="facebook">
							<span class="fa fa-facebook"></span>
							<span><?php esc_html_e("Share", 'betube') ?></span>
						</button>
						<span data-easyshare-button-count="facebook">0</span>

						<!-- Twitter -->
						<button data-easyshare-button="twitter" data-easyshare-tweet-text="">
							<span class="fa fa-twitter"></span>
							<span><?php esc_html_e("Tweet", 'betube') ?></span>
						</button>
						<span data-easyshare-button-count="twitter">0</span>

						<!-- Google+ -->
						<button data-easyshare-button="google">
							<span class="fa fa-google-plus"></span>
							<span>+1</span>
						</button>
						<span data-easyshare-button-count="google">0</span>

						<div data-easyshare-loader><?php esc_html_e("Loading", 'betube') ?>...</div>
					</div>
				</div><!--Social Share-->
				<div class="clearfix">
					<div class="profile-author-name float-left">
						<h4><?php echo $betubeDisplayName = get_the_author_meta('display_name', $user_ID); ?></h4>
						<?php $betubeRegDate = get_the_author_meta('user_registered', $user_ID); ?>
						<?php $dateFormat = get_option( 'date_format' );?>
						<p><?php esc_html_e("Join Date", 'betube') ?> : <span><?php echo date($dateFormat, strtotime($betubeRegDate));?></span></p>
					</div><!--profile-author-name-->
					<div class="profile-author-stats float-right">
						<ul class="menu">
							<li>
								<div class="icon float-left">
									<i class="fa fa-video-camera"></i>
								</div>
								<div class="li-text float-left">
									<p class="number-text"><?php echo count_user_posts($user_ID);?></p>
									<span><?php esc_html_e("Videos", 'betube') ?></span>
								</div>
							</li><!--Total Videos-->
							<li>
								<div class="icon float-left">
									<i class="fa fa-heart"></i>
								</div>
								<div class="li-text float-left">
									<p class="number-text">
									<?php 
										global $current_user;
										wp_get_current_user();
										$user_id = $current_user->ID;
										echo $totalfavorite = betubeFavoriteCount($user_id);
									?>
									</p>
									<span><?php esc_html_e("Favorites", 'betube') ?></span>
								</div>
							</li><!--Total favorites-->
							<li>
								<div class="icon float-left">
									<i class="fa fa-users"></i>
								</div>
								<div class="li-text float-left">
									<p class="number-text"><?php echo betubeFollowerCount($user_id);?></p>
									<span><?php esc_html_e("Followers", 'betube') ?></span>
								</div>
							</li><!--Total followers-->
							<li>
								<div class="icon float-left">
									<i class="fa fa-comments-o"></i>
								</div>
								<div class="li-text float-left">
								<?php 									
								$args = array(
									'user_id' => get_current_user_id(), // use user_id
									'count' => true, //return only the count
									'status' => 'approve'
								);
								$betubeUsercomments = get_comments($args);
								?>
									<p class="number-text"><?php echo $betubeUsercomments; ?></p>
									<span><?php esc_html_e("Comments", 'betube') ?></span>
								</div>
							</li><!--Total comments-->
						</ul>
					</div><!--profile-author-stats-->
				</div><!--clearfix-->
			</div><!--large-12-->
		</div><!--row secBg-->
	</div><!--end profile-stats-->
</section><!--end Section topProfile-->
<div class="row">
	<!-- left sidebar -->
	<div class="large-4 columns">
		<aside class="secBg sidebar">
			<div class="row">
				<!-- profile overview -->
				<div class="large-12 columns">
					<div class="widgetBox">
						<div class="widgetTitle">
							<h5><?php esc_html_e("PROFILE OVERVIEW", 'betube') ?></h5>
						</div>
						<div class="widgetContent">
						<?php 
						global $redux_demo;
						$betubeProfile = $redux_demo['profile'];
						$betubeVideoSingleUser = $redux_demo['all-video-single-user'];
						$betubeFavourite = $redux_demo['all-favourite'];
						$beTubeAddPost = $redux_demo['new_post'];
						$beTubefollowers = $redux_demo['all-followers'];
						$beTubeEditProfile = $redux_demo['edit-profile'];
						$user_info = get_userdata($user_ID);
						?>
							<ul class="profile-overview">
								<li class="clearfix">
									<a href="<?php echo $betubeProfile; ?>">
										<i class="fa fa-user"></i><?php esc_html_e("About Me", 'betube') ?>
									</a>
								</li><!--AboutMe-->
								<li class="clearfix">
									<a href="<?php echo $betubeVideoSingleUser; ?>">
										<i class="fa fa-video-camera"></i><?php esc_html_e("Videos", 'betube') ?> 
										<span class="float-right"><?php echo count_user_posts($user_ID);?></span>
									</a>
								</li><!--Videos-->
								<li class="clearfix">
									<a href="<?php echo $betubeFavourite; ?>">
										<i class="fa fa-heart"></i><?php esc_html_e("Favorite Videos", 'betube') ?>
										<span class="float-right">
											<?php 
												global $current_user;
												wp_get_current_user();
												$user_id = $current_user->ID;
												echo $totalfavorite = betubeFavoriteCount($user_id);
												?>
										</span>
									</a>
								</li><!--Favorite Videos-->
								<li class="clearfix">
									<a href="<?php echo $beTubefollowers; ?>">
										<i class="fa fa-users"></i><?php esc_html_e("Followers", 'betube') ?>
										<span class="float-right">
										<?php echo betubeFollowerCount($user_id);?>
										</span>
									</a>
								</li><!--Followers-->
								<li class="clearfix">
								<?php 									
								$args = array(
									'user_id' => get_current_user_id(), // use user_id
									'count' => true, //return only the count
									'status' => 'approve'
								);
								$betubeUsercomments = get_comments($args);
								?>
									<a href="#">
										<i class="fa fa-comments-o"></i><?php esc_html_e("comments", 'betube') ?>
										<span class="float-right"><?php echo $betubeUsercomments; ?></span>
									</a>
								</li><!--comments-->
								<li class="clearfix">
									<a class="active" href="<?php echo $beTubeEditProfile; ?>">
										<i class="fa fa-gears"></i><?php esc_html_e("Profile Settings", 'betube') ?>
									</a>
								</li><!--Profile Settings-->
								<li class="clearfix">
									<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>">
										<i class="fa fa-sign-out"></i><?php esc_html_e("Logout", 'betube') ?>
									</a>
								</li><!--Logout-->
								<?php if(!empty($beTubeAddPost)){?>
								<a href="<?php echo $beTubeAddPost; ?>" class="button">
									<i class="fa fa-plus-circle"></i><?php esc_html_e("Submit Video", 'betube') ?>
								</a><!--Submit Video-->
								<?php }?>
							</ul><!--UL-->
						</div><!--widgetContent -->
					</div><!--widgetBox -->
				</div><!--Large12 -->
				<!-- profile overview -->
			</div><!--row-->
		</aside>
	</div><!--large-4-->
	<!-- left sidebar -->
	<!-- right side content area -->
	<div class="large-8 columns profile-inner">
		<!-- profile settings -->
		<section class="profile-settings">
			<div class="row secBg">
				<div class="large-12 columns">
					<div class="heading">
						<i class="fa fa-gears"></i>
						<h4><?php esc_html_e("Profile Settings", 'betube') ?></h4>
					</div><!--heading-->
					<div class="row">
						<div class="large-12 columns">
							<div class="setting-form">
								<!--<form class="form-item" action="" id="primaryPostForm" method="POST" enctype="multipart/form-data">-->
									<div class="setting-form-inner error">
										<div class="large-12 columns">
											<?php echo $message; ?>
										</div>
									</div>
									<div class="setting-form-inner">
										<div class="row">
											<div class="large-12 columns">
												<h6 class="borderBottom"><?php esc_html_e("Username Setting", 'betube') ?>:</h6>
											</div><!--large-12-->
											<div class="medium-6 columns">
												<label><?php esc_html_e("First Name", 'betube') ?>:
													<input type="text" id="contactName" name="first_name" placeholder="<?php esc_html_e("Enter your first name", 'betube') ?>" value="<?php echo $user_info->first_name; ?>">
												</label>
											</div><!--First Name-->
											<div class="medium-6 columns">
												<label><?php esc_html_e("Last Name", 'betube') ?>:
													<input type="text" id="contactName" name="last_name" placeholder="<?php esc_html_e("Enter your last name", 'betube') ?>" value="<?php echo $user_info->last_name; ?>">
												</label>
											</div><!--Last Name-->
											<div class="medium-6 columns">
												<label><?php esc_html_e("Nick Name", 'betube') ?>:
													<input type="text" id="displayname" name="user_nicename" placeholder="<?php esc_html_e("Enter your nice Name", 'betube') ?>" value="<?php echo $user_info->user_nicename; ?>">
												</label>
											</div><!--Nick Name-->
											<div class="medium-6 columns">
												<label><?php esc_html_e("Display Name", 'betube') ?>:
													<input type="text" id="display_name" name="display_name" placeholder="<?php esc_html_e("Enter your Display Name", 'betube') ?>" value="<?php echo $user_info->display_name; ?>">
												</label>
											</div><!--Display Name-->
										</div><!--row-->
									</div><!--setting-form-inner-->
									<div class="setting-form-inner">
										<div class="row">
											<div class="large-12 columns">
												<h6 class="borderBottom"><?php esc_html_e("Profile Heading", 'betube') ?>:</h6>
											</div><!--Profile Heading Text-->
											<div class="medium-6 columns">
												<label><?php esc_html_e("First Heading", 'betube') ?>:
													<input type="text" name="betube_heading_one" id="betube_heading_one" placeholder="<?php esc_html_e("Worlds Biggest", 'betube') ?>" value="<?php echo $user_info->firsttext; ?>">
												</label>
											</div><!--First Heading-->
											<div class="medium-6 columns">
												<label><?php esc_html_e("Second Heading", 'betube') ?>:
													<input type="text" name="betube_heading_second" id="betube_heading_second" placeholder="<?php esc_html_e("Powerfull Video Theme", 'betube') ?>" value="<?php echo $user_info->secondtext; ?>">
												</label>
											</div><!--First Heading-->
										</div><!--row-->
									</div><!--setting-form-inner-->
									<div class="setting-form-inner">
										<div class="row">
											<div class="large-12 columns">
												<h6 class="borderBottom"><?php esc_html_e("Update Password", 'betube') ?>:</h6>
											</div><!--Update Password-->
											<div class="medium-6 columns">
												<label><?php esc_html_e("Current Password", 'betube') ?>:
													<input type="password" name="pwd" id="password" placeholder="<?php esc_html_e("Enter current password..", 'betube') ?>">
												</label>
											</div><!--New Password-->
											<div class="medium-6 columns">
												<label><?php esc_html_e("New Password", 'betube') ?>:
													<input type="password" id="password" name="confirm" placeholder="<?php esc_html_e("Enter new password..", 'betube') ?>">
												</label>
											</div><!--Retype Password-->
										</div><!--row-->
									</div><!--setting-form-inner-->
									<div class="setting-form-inner">
										<div class="row">
											<div class="large-12 columns">
												<h6 class="borderBottom"><?php esc_html_e("About Me", 'betube') ?>:</h6>
											</div><!--large-12-->
											<div class="medium-6 columns">
												<label><?php esc_html_e("Email ID", 'betube') ?>:
													<input type="email" id="email" name="email" placeholder="<?php esc_html_e("enter your email address..", 'betube') ?>" value="<?php echo $user_info->user_email; ?>">
												</label>
											</div><!--Email ID-->
											<div class="medium-6 columns">
												<label><?php esc_html_e("Website URL", 'betube') ?>:
													<input type="url" id="website" name="website" placeholder="<?php esc_html_e("Enter your Website URL", 'betube') ?>" value="<?php echo $user_info->user_url; ?>">
												</label>
											</div><!--Website URL-->
											<div class="medium-6 columns end">
												<label><?php esc_html_e("Phone No", 'betube') ?>:
													<input type="tel" placeholder="<?php esc_html_e("Enter your phone number", 'betube') ?>" name="phone" value="<?php echo $user_info->phone; ?>">
												</label>
											</div><!--Phone No-->
											<div class="medium-12 columns">
												<label><?php esc_html_e("About", 'betube') ?>:
													<textarea name="desc" id="desc" class="text" placeholder="<?php esc_html_e( 'About', 'betube' ); ?>" rows="10"><?php echo $user_info->description; ?></textarea>
												</label>
											</div><!--About-->
										</div><!--row-->
									</div><!--setting-form-inner-->
									<div class="setting-form-inner">
										<div class="row">
											<div class="large-12 columns">
												<h6 class="borderBottom"><?php esc_html_e("Social Profile links", 'betube') ?>:</h6>
											</div><!--Social Profile-->
											<div class="medium-6 columns">
												<label><?php esc_html_e("Facebook", 'betube') ?>:
													<input type="url" id="facebook" name="facebook" placeholder="<?php esc_html_e("Your facebook url", 'betube') ?>" value="<?php echo $user_info->facebook; ?>">
												</label>
											</div><!--facebook-->
											<div class="medium-6 columns">
												<label><?php esc_html_e("Twitter", 'betube') ?>:
													<input type="url" id="twitter" name="twitter" placeholder="<?php esc_html_e("Your twitter URL", 'betube') ?>" <?php echo $user_info->twitter; ?>>
												</label>
											</div><!--twitter-->
											<div class="medium-6 columns end">
												<label><?php esc_html_e("Google Plus", 'betube') ?>:
													<input type="url" id="google-plus" name="google-plus" placeholder="<?php esc_html_e("Your Google Plus URL", 'betube') ?>" value="<?php echo $user_info->googleplus; ?>">
												</label>
											</div><!--Google Plus-->
											<div class="medium-6 columns">
												<label><?php esc_html_e("Youtube", 'betube') ?>:
													<input type="url" name="youtube" id="youtube" placeholder="<?php esc_html_e("Your Youtube URL", 'betube') ?>" value="<?php echo $user_info->youtube; ?>">
												</label>
											</div><!--Youtube-->
											<div class="medium-6 columns">
												<label><?php esc_html_e("Vimeo", 'betube') ?>:
													<input type="url" id="vimeo" name="vimeo" placeholder="<?php esc_html_e("Your Vimeo URL", 'betube') ?>" value="<?php echo $user_info->vimeo; ?>">
												</label>
											</div><!--vimeo-->
											<div class="medium-6 columns end">
												<label><?php esc_html_e("Pinterest", 'betube') ?>:
													<input type="url" id="pinterest" name="pinterest" placeholder="<?php esc_html_e("Your Pinterest URL", 'betube') ?>" value="<?php echo $user_info->pinterest; ?>">
												</label>
											</div><!--Pinterest-->
											<div class="medium-6 columns">
												<label><?php esc_html_e("Instagram", 'betube') ?>:
													<input type="url" id="instagram" name="instagram" placeholder="<?php esc_html_e("Your Instagram URL", 'betube') ?>" value="<?php echo $user_info->instagram; ?>">
												</label>
											</div><!--Instagram-->
											<div class="medium-6 columns end">
												<label><?php esc_html_e("Linkedin", 'betube') ?>:
													<input type="url" id="linkedin" name="linkedin" placeholder="<?php esc_html_e("Your Linkedin URL", 'betube') ?>" value="<?php echo $user_info->linkedin; ?>">
												</label>
											</div><!--Linkedin-->											
											<!--Author BG-->
											<!--<input class="author-bg-image" id="author-bg-image" type="hidden" name="upload_attachment[]" value="" />-->
											<!--Author BG-->
											<!--Author IMG-->
											<input class="criteria-image-url" id="your_image_url" type="hidden" name="your_author_image_url" value="" />
											<!--Author IMG-->
										</div><!--row-->
									</div><!--setting-form-inner-->
									<div class="setting-form-inner">
										<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
										<input type="hidden" name="submitted" id="submitted" value="true" />
										<button class="button expanded" type="submit" name="op"><?php esc_html_e("Update", 'betube') ?></button>
									</div>
								<!--</form>-->
							</div><!--End setting-form-->
						</div><!--End large-12-->
					</div><!--End Row-->
				</div><!--large-12-->
			</div><!--End row secBg-->
		</section><!--End profile-settings-->
		<!-- profile settings -->
	</div>
	<!-- right side content area -->
</div><!--End Row-->
</form>
<?php endwhile; ?>
<script>
	
</script>
<?php get_footer(); ?>