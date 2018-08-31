<?php
/**
 * Template name: Edit Post
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage betube
 * @since betube 1.0
 */

if ( !is_user_logged_in() ) {
	wp_redirect( home_url() ); exit;
} else { 

}
$postContent = '';$caticoncolor="";
global $current_user;wp_get_current_user();$userID = $current_user->ID;
$query = new WP_Query(array('post_type' => 'post', 'posts_per_page' =>'-1') );
if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
	if(isset($_GET['post'])) {	
		if($_GET['post'] == $post->ID)
		{
						$author = get_the_author_meta('ID');
			if($author != $userID) {
				wp_redirect( home_url() ); exit;
			}						$current_post = $post->ID;
			$title = get_the_title();
			$content = get_the_content();
			$posttags = get_the_tags($current_post);
			if ($posttags) {
			  foreach($posttags as $tag) {
				$tags_list = $tag->name . ' '; 
			  }
			}
			$postcategory = get_the_category( $current_post );			
			$category_id = $postcategory[0]->cat_ID;			
			$post_category_type = get_post_meta($post->ID, 'post_category_type', true);
			$betubeVideoLayout = get_post_meta($post->ID, 'jtheme_video_layout', true);						$videoCustomVideoLink = get_post_meta($post->ID, 'jtheme_video_file', true);			$betubeEmbedCode = get_post_meta($post->ID, 'jtheme_video_code', true);
			$betubeVideoLink = get_post_meta($post->ID, 'jtheme_video_url', true);
			$betubeVideoLink2 = get_post_meta($post->ID, 'single_video_link_second', true);
			$betubeVideoLink3 = get_post_meta($post->ID, 'single_video_link_third', true);						$betubePostTime = get_post_meta($post->ID, 'post_time', true);			$betubePostQuality = get_post_meta($post->ID, 'post_quality', true);			$betubeHDPost = get_post_meta($post->ID, 'hd_post', true);
			
			if ( has_post_thumbnail() ) {		
				$post_thumbnail = get_the_post_thumbnail($current_post, 'thumbnail');		
			} 
		}
	}

endwhile; endif;
wp_reset_query();global $current_post;global $redux_demo;
$postTitleError = '';
$post_priceError = '';
$catError = '';
if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {
	if(trim($_POST['postTitle']) === '') {
		$postTitleError = 'Please enter a title.';
		$hasError = true;
	} else {
		$postTitle = trim($_POST['postTitle']);
	}
	if(trim($_POST['cat']) === '-1') {
		$catError = 'Please select a category.';
		$hasError = true;
	} 		
	if($hasError != true) {
		if(is_super_admin() ){
			$beTubepostStatus = 'publish';
		}elseif(!is_super_admin()){		
			if($redux_demo['post-options-edit-on'] == 1){
				$beTubepostStatus = 'pending';
			}else{
				$beTubepostStatus = 'publish';
			}
		}				$mCatID = $_POST['cat'];				
		$post_information = array(
			'ID' => $current_post,
			'post_title' => esc_attr(strip_tags($_POST['postTitle'])),
			'post_content' => strip_tags($_POST['video-body'], '<a><h1><h2><h3><strong><b><ul><li><i><a>'),
			'post-type' => 'post',
			'post_category' => array($mCatID),
	        'tags_input'    => explode(',', $_POST['post_tags']),
	        'comment_status' => 'open',
	        'ping_status' => 'open',
			'post_status' => $beTubepostStatus
		);
		$post_id = wp_insert_post($post_information);				$betubeVideoLink = $_POST['video_link'];		$betubeVideoLink2 = $_POST['video_link2'];		$betubeVideoLink3 = $_POST['video_link3'];		$videoCustomVideoLink = $_POST['video_custom_link'];		$betubeEmbedCode = $_POST['video_embed_code'];		$betubeVideoLayout = $_POST['radio-btns-sprite'];		$betubeFeaturedIMGURL = $_POST['featured-image-url'];		$betubeIMGIDURL = $_POST['criteria-image-id'];		$betubePostTime = $_POST['post_time'];		$betubePostQuality = $_POST['post_quality'];		$hd_post = $_POST['hd_post'];		if(isset($hd_post)){			$betubeHDPost = '1';		}else{			$betubeHDPost = '2';		}
		update_post_meta($post_id, 'post_category_type', esc_attr( $_POST['post_category_type'] ) );
		update_post_meta($post_id, 'jtheme_video_layout', $betubeVideoLayout, $allowed);					if(!empty($videoCustomVideoLink)){			update_post_meta($post_id, 'jtheme_video_file', $videoCustomVideoLink, $allowed);		}		if(!empty($betubeEmbedCode)){			update_post_meta($post_id, 'jtheme_video_code', $betubeEmbedCode, $allowed);		}		if(!empty($betubeVideoLink)){			update_post_meta($post_id, 'jtheme_video_url', $betubeVideoLink, $allowed);		}		/*Extra Video Links*/		if(!empty($betubeVideoLink2)){			update_post_meta($post_id, 'single_video_link_second', $betubeVideoLink2, $allowed);		}		if(!empty($betubeVideoLink3)){			update_post_meta($post_id, 'single_video_link_third', $betubeVideoLink3, $allowed);		}
		/*Duration*/		if(!empty($betubeVideoLink3)){			update_post_meta($post_id, 'post_time', $betubePostTime, $allowed);		}		/*Duration*/		/*Quality*/		if(!empty($betubePostQuality)){			update_post_meta($post_id, 'post_quality', $betubePostQuality, $allowed);		}		/*Quality*/		/*HD*/		if(!empty($betubeHDPost)){			update_post_meta($post_id, 'hd_post', $betubeHDPost, $allowed);		}		/*HD*/
		$permalink = get_permalink( $post_id );		
		global $post;		/*Video Uploading*/			if ( isset($_FILES['upload_attachment']) ) {				$count = '0';				$files = $_FILES['upload_attachment'];				foreach ($files['name'] as $key => $value) {					if ($files['name'][$key]) {						$file = array(							'name'     => $files['name'][$key],							'type'     => $files['type'][$key],							'tmp_name' => $files['tmp_name'][$key],							'error'    => $files['error'][$key],							'size'     => $files['size'][$key]						);						$_FILES = array("upload_attachment" => $file);						foreach ($_FILES as $file => $array) {							$newupload = betube_insert_attachment($file,$post->ID);							//add_post_meta($post_id, 'jtheme_video_file', $newupload);							$attachvideo = wp_get_attachment_url( $newupload);							add_post_meta($post_id, 'jtheme_video_file', $attachvideo);							add_post_meta($post_id, '_video_thumbnail', $newupload);							set_post_thumbnail( $post_id, $newupload );							$count++;						}					}				}							}			/*Video Uploading*/		set_post_thumbnail( $post_id, $betubeIMGIDURL );
		if (isset($_POST['att_remove'])) {
			foreach ($_POST['att_remove'] as $att_id){
				wp_delete_attachment($att_id);
			}
		}		
		wp_redirect( $permalink ); exit;
	}
} 

get_header();betube_breadcrumbs();?>
<?php 	$page = get_page($post->ID);	$current_page_id = $page->ID;	wp_get_current_user();		$betubeProfileIMG = get_user_meta($user_ID, "betube_author_profile_bg", true);	if(!empty($betubeProfileIMG)){		$betubeProfileIMG = betube_get_image_url($betubeProfileIMG);	}?>	<?php //while ( have_posts() ) : the_post(); ?><section class="topProfile topProfile-inner" style="background: url('<?php echo $betubeProfileIMG; ?>') no-repeat;">	<div class="main-text">		<div class="row">			<div class="large-12 columns">			<?php 				$betubeFirstTXT = the_author_meta('firsttext', $user_id);				$betubeSecondTXT = the_author_meta('secondtext', $user_id);			?>			<?php if(!empty($betubeFirstTXT)){?>				<h3><?php echo $betubeFirstTXT; ?></h3>			<?php } ?>				<?php if(!empty($betubeSecondTXT)){?>				<h1><?php echo $betubeSecondTXT; ?></h1>			<?php } ?>				</div><!--large-12-->		</div><!--row-->	</div><!--main-text-->	<div class="profile-stats">		<div class="row secBg">			<div class="large-12 columns">			<?php 						$authorAvatarURL = get_user_meta($user_ID, "betube_author_avatar_url", true);			$authorAvatarURL = betube_get_image_url($authorAvatarURL);			if(!empty($authorAvatarURL)) {								?>				<div class="profile-author-img">					<img src="<?php echo esc_url($authorAvatarURL); ?>" alt="author">				</div>				<?php			}else{				$authorID = get_the_author_meta('user_email', $user_ID);				$avatar_url = betube_get_avatar_url($authorID, $size = '150' );				?>				<div class="profile-author-img">					<img src="<?php echo esc_url($avatar_url); ?>" alt="profile author img">				</div><!--profile-author-img-->				<?php			}			?>				<div class="profile-subscribe">					<span><i class="fa fa-users"></i>6</span>					<button type="submit" name="subscribe">subscribe</button>				</div><!--profile-subscribe-->				<div class="profile-share">					<div class="easy-share" data-easyshare data-easyshare-http data-easyshare-url="<?php echo esc_url( home_url( '/' ) ); ?>">						<!-- Facebook -->						<button data-easyshare-button="facebook">							<span class="fa fa-facebook"></span>							<span><?php esc_html_e("Share", 'betube') ?></span>						</button>						<span data-easyshare-button-count="facebook">0</span>						<!-- Twitter -->						<button data-easyshare-button="twitter" data-easyshare-tweet-text="">							<span class="fa fa-twitter"></span>							<span><?php esc_html_e("Tweet", 'betube') ?></span>						</button>						<span data-easyshare-button-count="twitter">0</span>						<!-- Google+ -->						<button data-easyshare-button="google">							<span class="fa fa-google-plus"></span>							<span>+1</span>						</button>						<span data-easyshare-button-count="google">0</span>						<div data-easyshare-loader><?php esc_html_e("Loading", 'betube') ?>...</div>					</div>				</div><!--Social Share-->				<div class="clearfix">					<div class="profile-author-name float-left">						<h4><?php echo $betubeDisplayName = get_the_author_meta('display_name', $user_ID); ?></h4>						<?php $betubeRegDate = get_the_author_meta('user_registered', $user_ID); ?>						<?php $dateFormat = get_option( 'date_format' );?>						<p><?php esc_html_e("Join Date", 'betube') ?> : <span><?php echo date($dateFormat, strtotime($betubeRegDate));?></span></p>					</div><!--profile-author-name-->					<div class="profile-author-stats float-right">						<ul class="menu">							<li>								<div class="icon float-left">									<i class="fa fa-video-camera"></i>								</div>								<div class="li-text float-left">									<p class="number-text"><?php echo count_user_posts($user_ID);?></p>									<span><?php esc_html_e("Videos", 'betube') ?></span>								</div>							</li><!--Total Videos-->							<li>								<div class="icon float-left">									<i class="fa fa-heart"></i>								</div>								<div class="li-text float-left">									<p class="number-text">									<?php 										global $current_user;										wp_get_current_user();										$user_id = $current_user->ID;										echo $totalfavorite = betubeFavoriteCount($user_id);									?>									</p>									<span><?php esc_html_e("Favorites", 'betube') ?></span>								</div>							</li><!--Total favorites-->							<li>								<div class="icon float-left">									<i class="fa fa-users"></i>								</div>								<div class="li-text float-left">									<p class="number-text"><?php echo betubeFollowerCount($user_id);?></p>									<span><?php esc_html_e("Followers", 'betube') ?></span>								</div>							</li><!--Total followers-->							<li>								<div class="icon float-left">									<i class="fa fa-comments-o"></i>								</div>								<div class="li-text float-left">								<?php 																	$args = array(									'user_id' => get_current_user_id(), // use user_id									'count' => true, //return only the count									'status' => 'approve'								);								$betubeUsercomments = get_comments($args);								?>									<p class="number-text"><?php echo $betubeUsercomments; ?></p>									<span><?php esc_html_e("Comments", 'betube') ?></span>								</div>							</li><!--Total comments-->						</ul>					</div><!--profile-author-stats-->				</div><!--clearfix-->			</div><!--large-12-->		</div><!--row secBg-->	</div><!--profile-stats--></section>
<div class="row">	<!--left sidebar-->	<div class="large-4 columns">		<aside class="secBg sidebar">			<div class="row">				<!-- profile overview -->				<div class="large-12 columns">					<div class="widgetBox">						<div class="widgetTitle">							<h5><?php esc_html_e("Profile OVERVIEW", 'betube') ?></h5>						</div>						<div class="widgetContent">						<?php 						global $redux_demo;						$betubeProfile = $redux_demo['profile'];						$betubeVideoSingleUser = $redux_demo['all-video-single-user'];						$betubeFavourite = $redux_demo['all-favourite'];						$beTubeAddPost = $redux_demo['new_post'];						$beTubefollowers = $redux_demo['all-followers'];						$beTubeEditProfile = $redux_demo['edit-profile'];						?>							<ul class="profile-overview">								<li class="clearfix">									<a class="active" href="<?php echo $betubeProfile; ?>">										<i class="fa fa-user"></i><?php esc_html_e("About Me", 'betube') ?>									</a>								</li><!--AboutMe-->								<li class="clearfix">									<a href="<?php echo $betubeVideoSingleUser; ?>">										<i class="fa fa-video-camera"></i><?php esc_html_e("Videos", 'betube') ?> 										<span class="float-right"><?php echo count_user_posts($user_ID);?></span>									</a>								</li><!--Videos-->								<li class="clearfix">									<a href="<?php echo $betubeFavourite; ?>">										<i class="fa fa-heart"></i><?php esc_html_e("Favorite Videos", 'betube') ?>										<span class="float-right">											<?php 												global $current_user;												wp_get_current_user();												$user_id = $current_user->ID;												echo $totalfavorite = betubeFavoriteCount($user_id);												?>										</span>									</a>								</li><!--Favorite Videos-->								<li class="clearfix">									<a href="#">										<i class="fa fa-users"></i><?php esc_html_e("Followers", 'betube') ?>										<span class="float-right">										<?php echo betubeFollowerCount($user_id);?>										</span>									</a>								</li><!--Followers-->								<li class="clearfix">								<?php 																	$args = array(									'user_id' => get_current_user_id(), // use user_id									'count' => true, //return only the count									'status' => 'approve'								);								$betubeUsercomments = get_comments($args);								?>									<a href="#">										<i class="fa fa-comments-o"></i><?php esc_html_e("comments", 'betube') ?>										<span class="float-right"><?php echo $betubeUsercomments; ?></span>									</a>								</li><!--comments-->								<li class="clearfix">									<a href="<?php echo $beTubeEditProfile; ?>">										<i class="fa fa-gears"></i><?php esc_html_e("Profile Settings", 'betube') ?>									</a>								</li><!--Profile Settings-->								<li class="clearfix">									<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>">										<i class="fa fa-sign-out"></i><?php esc_html_e("Logout", 'betube') ?>									</a>								</li><!--Logout-->								<a href="<?php echo $beTubeAddPost; ?>" class="button">									<i class="fa fa-plus-circle"></i><?php esc_html_e("Submit Video", 'betube') ?>								</a><!--Submit Video-->							</ul><!--UL-->						</div><!--widgetContent -->					</div><!--widgetBox -->				</div><!--Large12 -->			</div><!--row-->		</aside><!--aside-->	</div><!--Large4-->	<!--left sidebar-->	<!-- right side content area -->	<div class="large-8 columns profile-inner">		<section class="submit-post">			<div class="row secBg">				<div class="large-12 columns">					<div class="heading">						<i class="fa fa-pencil-square-o"></i>						<h4><?php esc_html_e("Edit video Post", 'betube') ?></h4>					</div><!--heading-->					<div class="row">						<div class="large-12 columns">							<form data-abide novalidate method="POST" id="editPostForm" enctype="multipart/form-data">								<div data-abide-error class="alert callout" style="display: none;">									<p>										<i class="fa fa-exclamation-triangle"></i>										<?php if($postTitleError != '') {echo $postTitleError; }?>										<?php esc_html_e("There are some errors in your form.", 'betube') ?>									</p>								</div><!--alert callout-->								<div class="row">									<div class="large-12 columns">										<label><?php esc_html_e("Title", 'betube') ?>:											<input type="text" value="<?php echo $title; ?>" id="postTitle" name="postTitle" placeholder="<?php esc_html_e("Enter your Video Title", 'betube') ?>..." required>											<span class="form-error">												<?php esc_html_e("Yo, you had better fill this out, it's required.", 'betube') ?>											</span>										</label>									</div><!--End Title-->									<div class="large-12 columns">										<label><?php esc_html_e("Description", 'betube') ?>:											<textarea name="video-body" id="video-body"><?php echo $content; ?></textarea>										</label>									</div><!--End Description-->									<?php 									global $redux_demo;									$betubeCustomUpload = $redux_demo['betube-custom-uploading'];									if($betubeCustomUpload == 1){									?>									<div class="large-12 columns">										<h6 class="borderBottom"><?php esc_html_e("Choose Video Method", 'betube') ?>:</h6>										<p><strong><?php esc_html_e("Note", 'betube') ?>:</strong> <?php esc_html_e("Please choose one of the following ways to embed the video into your post, the video is determined in the order: Video Code > Video URL > Video File.", 'betube') ?></p>									</div><!--Choose Method-->									<div class="large-12 columns">										<div class="radio trigger">										   <input type="radio" value="check" name="videolink" id="videolink1" <?php if(!empty($betubeVideoLink)){echo "checked";}?>>										   <label class="customLabel" for="videolink1"><?php esc_html_e("Video Link From Youtube/Vimeo etc", 'betube') ?>..</label>										   <input type="radio" value="check" name="videolink" id="videolink2" <?php if(!empty($videoCustomVideoLink)){echo "checked";}?>>										   <label class="customLabel" for="videolink2"><?php esc_html_e("Custom Video Upload / Put custom Video URL", 'betube') ?> </label>										   <input type="radio" value="check" name="videolink" id="videolink3" <?php if(!empty($betubeEmbedCode)){echo "checked";}?>>										   <label class="customLabel" for="videolink3"><?php esc_html_e("Embed/Object Code", 'betube') ?></label>										</div>									</div><!--Choose Option-->									<div class="large-12 columns radio-video-links">										<div data-id="videolink1" style="display: block">											<label><?php esc_html_e("Put here your video Link from youtube/vimeo/dailymotion etc..", 'betube') ?>:												<input type="url" name="video_link" value="<?php echo $betubeVideoLink;?>" placeholder="<?php esc_html_e("http://youtube.com/xkijkbh", 'betube') ?>">												<?php 												$betubeMultiPlayer = $redux_demo['betube-multi-player'];												if($betubeMultiPlayer == 1){												?>												<input type="url" name="video_link2" value="<?php echo $betubeVideoLink2;?>" placeholder="<?php esc_html_e("http://youtube.com/xkijkbh", 'betube') ?>">												<input type="url" name="video_link3" value="<?php echo $betubeVideoLink3;?>" placeholder="<?php esc_html_e("http://youtube.com/xkijkbh", 'betube') ?>">												<?php } ?>											</label>										</div>										<div data-id="videolink2">																					<label><?php esc_html_e("Put here your video url with proper extension", 'betube') ?>:												<input type="text" value="<?php echo $videoCustomVideoLink; ?>" name="video_custom_link" placeholder="<?php esc_html_e("http://yoursite.com/sample-video.mp4", 'betube') ?>">											</label>											<p class="extraMargin"><?php esc_html_e("Paste your video file url to here. Supported Video Formats: mp4, m4v, webmv, webm, ogv and flv. About Cross-platform and Cross-browser Support. If you want your video works in all platforms and browsers(HTML5 and Flash), you should provide various video formats for same video, if the video files are ready, enter one url per line. For Example: http://yousite.com/sample-video.m4v http://yousite.com/sample-video.ogv Recommended Format Solution: webmv + m4v + ogv", 'betube') ?>.</p>											<h6><?php esc_html_e("OR", 'betube') ?></h6>											<div class="video">																								<input type="file" id="videoUpload" name="upload_attachment[]">											</div>																					</div><!--videolink2-->										<div data-id="videolink3">											<textarea name="video_embed_code" placeholder="<?php esc_html_e("Paste your embed code here", 'betube') ?>"><?php echo $betubeEmbedCode; ?></textarea>										</div><!--videolink3-->									</div><!--End Video Code Options-->									<?php }else{ ?>										<div class="large-12 columns">											<label><?php esc_html_e("Put Your Video Link from YouTube, Vimeo etc", 'betube') ?>:												<input type="text" name="video_link" value="<?php echo $betubeVideoLink;?>" placeholder="<?php esc_html_e("http://youtube.com/xkijkbh", 'betube') ?>">											</label>										</div>									<?php } ?>									<div class="large-12 columns">																			<div class="post-category">											<label><?php esc_html_e("Choose Video Category", 'betube') ?>:											<?php 												$currCatID = $category_id;											$args = array(												'show_option_none' => esc_html__( 'Select category', 'betube' ),												'selected' => $category_id,											  );											  $currCatID = $category_id;											?>											<?php wp_dropdown_categories($args); ?>											</label>										</div>																				<fieldset class="input-title">											<label for="edit-field-category-und" class="control-label"><?php esc_html_e('Images', 'betube') ?></label>											<div id="edit-post-images-block">												<?php													$attachments = get_children(array('post_parent' => $current_post,																	'post_status' => 'inherit',																	'post_type' => 'attachment',																	'post_mime_type' => 'image',																	'order' => 'ASC',																	'orderby' => 'menu_order ID'));													foreach($attachments as $att_id => $attachment) {																	$attachment_ID = $attachment->ID;																	$full_img_url = wp_get_attachment_url($attachment->ID);																	$split_pos = strpos($full_img_url, 'wp-content');																	$split_len = (strlen($full_img_url) - $split_pos);																	$abs_img_url = substr($full_img_url, $split_pos, $split_len);																	$full_info = @getimagesize(ABSPATH.$abs_img_url);												?>													<div id="<?php echo $attachment_ID; ?>" class="edit-post-image-block">														<img class="edit-post-image" src="<?php echo $full_img_url; ?>" />														<div class="remove-edit-post-image">															<i class="fa fa-minus-square-o"></i>															<span class="remImage"><?php _e('Remove', 'betube');?></span> 															<input type="hidden" name="" value="<?php echo $attachment_ID; ?>">														</div>													</div>																											<?php													}												?>											</div>										</fieldset>										<?php 										$betubeCustomUpload = $redux_demo['betube-custom-uploading'];										if($betubeCustomUpload == 1){										?>										<div class="upload-video">											<label for="imgfileupload" class="btn-upload"><i class="fa fa-camera"></i><span class=""><?php esc_html_e("Upload Image", 'betube') ?></span></label>											<input type="text" id="imgfileupload" class="upload-featured-image show-for-sr">											<input class="featured-image-url" id="featured-image-url" type="hidden" name="featured-image-url" value="" />											<input class="criteria-image-id" id="criteria-image-id" type="hidden" name="criteria-image-id" value="" />										</div>										<div class="displayIMG">											<img class="featuredIMG" src="" alt="Post Featured Image" />										</div>										<p><?php esc_html_e("Upload image Only if you want to set any Featured Image, Otherwise leave it.", 'betube') ?></p>										<?php }?>									</div><!--End SEO Meta, Images, Category-->													<div class="large-12 columns">										<div class="video-sprite clearfix">											<div class="video-layout">												<input type="radio" id="radio-img-1" name="radio-btns-sprite" value="fullwidth">												<label for="radio-img-1" class="fullwidth"><?php esc_html_e("FullWidth", 'betube') ?></label>												<span><?php esc_html_e("FullWidth", 'betube') ?></span>											</div><!--video-layout-Full-width-->											<div class="video-layout">												<input type="radio" id="radio-img-2" value="standarad" name="radio-btns-sprite" checked>												<label for="radio-img-2" class="standard"><?php esc_html_e("Standarad", 'betube') ?></label>												<span><?php esc_html_e("Standarad", 'betube') ?></span>											</div><!--video-layout-Standarad-->										</div><!--video-sprite-->									</div><!--Choose Layout-->									<!--Videotime-->									<div class="large-12 columns">										<label><?php esc_html_e("Duration", 'betube') ?>:											<input type="text" name="post_time" id="post_time" value="<?php echo $betubePostTime; ?>" placeholder="<?php esc_html_e("Enter Video Duration Time like 15:20", 'betube') ?>">										</label>									</div>									<!--Videotime-->									<!--Quality-->									<div class="large-12 columns">										<label><?php esc_html_e("Quality", 'betube') ?>:											<input type="text" name="post_quality" id="post_quality" value="<?php echo $betubePostQuality; ?>" placeholder="<?php esc_html_e("Enter Video Quality like HD, 720p, 320p", 'betube') ?>">										</label>									</div>									<!--Quality-->									<!--HDPOST-->									<div class="large-12 columns">										<div class="checkbox">											<input type="checkbox" name="hd_post" id="hd_post" value="<?php echo $betubeHDPost; ?>" <?php if($betubeHDPost == 1){ echo 'checked';}?>>											<label class="customLabel" for="hd_post"><?php esc_html_e("Is this HD Video? Check this if its HD Video", 'betube') ?>	</label>										</div>									</div>									<!--HDPOST-->									<?php $betubeTags = $redux_demo['betube-tags-on']; ?>									<?php if($betubeTags == 1){?>									<div class="large-12 columns">									<label><?php esc_html_e("Tags", 'betube') ?>:									<?php									echo "<input type='text' id='post_tags' name='post_tags' value='";										$posttags = get_the_tags($current_post);										if ($posttags) {										  foreach($posttags as $tag) {											$tags_list = $tag->name . ', '; 											echo $tags_list;										  }										}										echo "' size='12' maxlength='110'>"; 									 ?>									 </label>																			</div><!--End Tags-->									<?php } ?>									<div class="large-12 columns">										<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>										<input type="hidden" name="submitted" id="submitted" value="true" />										<button class="button expanded" type="submit" name="submit"><?php esc_html_e("Publish Now", 'betube') ?></button>									</div><!--Publish Button-->									</div><!--Row-->							</form><!--End Form-->						</div><!--large-12 columns-->					</div><!--End Row-->				</div><!--large-12-->			</div><!--row secBg-->		</section><!--submit-post-->	</div><!--Large8-->	<!-- right side content area --></div><!--row--><?php //endwhile; ?><script>	var image_custom_uploader;	var $thisItem = '';	jQuery(document).on('click','.upload-featured-image', function(e) {		e.preventDefault();				$thisItem = jQuery(this);		$form = jQuery('#editPostForm');				//Extend the wp.media object		image_custom_uploader = wp.media.frames.file_frame = wp.media({			title: 'Choose Image',			button: {				text: 'Choose Image'			},			multiple: false		});		//When a file is selected, grab the URL and set it as the text field's value		image_custom_uploader.on('select', function() {			attachment = image_custom_uploader.state().get('selection').first().toJSON();			var url = '';			url = attachment['url'];			var attachId = '';			attachId = attachment['id'];			$thisItem.parent().parent().find( "img.featuredIMG" ).attr({				src: url			});		  $form.parent().parent().find( ".featured-image-url" ).attr({				value: url			});			$form.parent().parent().find( ".criteria-image-id" ).attr({				value: attachId			});					});		//Open the uploader dialog		image_custom_uploader.open();	});	</script>
<?php get_footer(); ?>