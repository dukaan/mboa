<?php
/**
 * Template name: Single User All Video
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage betube
 * @since betube
 */

if ( !is_user_logged_in() ) { 

	global $redux_demo; 
	$login = $redux_demo['login'];
	wp_redirect( $login ); exit;

}


global $redux_demo; 
$edit = $redux_demo['edit'];
$pagepermalink = get_permalink($post->ID);
if(isset($_GET['delete_id'])){
	$deleteUrl = $_GET['delete_id'];
	wp_delete_post($deleteUrl);
}
global $current_user, $user_id;
wp_get_current_user();
$user_info = get_userdata($user_ID);
$user_id = $current_user->ID; // You can set $user_id to any users, but this gets the current users ID.

get_header(); 
betube_breadcrumbs();

?>
<?php 
global $redux_demo; 
$profile = $redux_demo['profile'];
$all_adds = $redux_demo['all-ads'];
$allFavourite = $redux_demo['all-favourite'];
$newPostAds = $redux_demo['new_post'];
?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$betubeProfileIMG = get_user_meta($user_ID, "betube_author_profile_bg", true);
	if(!empty($betubeProfileIMG)){
		$betubeProfileIMG = betube_get_image_url($betubeProfileIMG);
	}
?>
<section class="topProfile" style="background: url('<?php echo $betubeProfileIMG; ?>') no-repeat;">
	<div class="main-text text-center">
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
		</div><!--Row upload cover-->	
	</div>
	<div class="profile-stats">
		<div class="row secBg">
			<div class="large-12 columns">
				<div class="profile-author-img">
					<?php 
					$author_avatar_url = get_user_meta($user_ID, "betube_author_avatar_url", true);
					$author_avatar_url = betube_get_image_url($author_avatar_url);
					if(!empty($author_avatar_url)) {
						?>
						<img src="<?php echo esc_url($author_avatar_url); ?>" alt="author">
						<?php
					}else{
						$avatar_url = betube_get_avatar_url ( get_the_author_meta('user_email', $user_ID), $size = '130' );
						?>
						<img class="author-avatar" src="<?php echo $avatar_url; ?>" alt="" />
						<?php
					}
					?>					
				</div><!--profile-author-img-->
				<div class="profile-subscribe">
					<span><i class="fa fa-users"></i><?php echo betubeFollowerCount($user_id);?></span>
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
	<!--LeftSidebar-->
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
						$beTubeallFollowers = $redux_demo['all-followers'];
						$beTubeAddPost = $redux_demo['new_post'];
						$beTubefollowers = $redux_demo['all-followers'];
						$beTubeEditProfile = $redux_demo['edit-profile'];
						?>
							<ul class="profile-overview">
								<li class="clearfix">
									<a href="<?php echo $betubeProfile; ?>">
										<i class="fa fa-user"></i><?php esc_html_e("About Me", 'betube') ?>
									</a>
								</li><!--AboutMe-->
								<li class="clearfix">
									<a class="active" href="<?php echo $betubeVideoSingleUser; ?>">
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
									<a href="<?php echo $beTubeallFollowers; ?>">
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
									<a href="<?php echo $beTubeEditProfile; ?>">
										<i class="fa fa-gears"></i><?php esc_html_e("Profile Settings", 'betube') ?>
									</a>
								</li><!--Profile Settings-->
								<li class="clearfix">
									<a href="<?php echo wp_logout_url(get_option('siteurl')); ?>">
										<i class="fa fa-sign-out"></i><?php esc_html_e("Logout", 'betube') ?>
									</a>
								</li><!--Logout-->
								<a href="<?php echo $beTubeAddPost; ?>" class="button">
									<i class="fa fa-plus-circle"></i><?php esc_html_e("Submit Video", 'betube') ?>
								</a><!--Submit Video-->
							</ul><!--UL-->
						</div><!--widgetContent -->
					</div><!--widgetBox -->
				</div><!--Large12 -->
			</div><!--row-->
		</aside>
	</div>
	<!--LeftSidebar-->
	<div class="large-8 columns profile-inner">
		<section class="profile-videos">
			<div class="row secBg">
				<div class="large-12 columns">
					<div class="heading">
						<i class="fa fa-video-camera"></i>
						<h4><?php esc_html_e("My Videos", 'betube') ?></h4>
					</div><!--Heading-->
					<?php
					global $paged, $wp_query, $wp;
					$args = wp_parse_args($wp->matched_query);
					if ( !empty ( $args['paged'] ) && 0 == $paged ) {
							$wp_query->set('paged', $args['paged']);
							$paged = $args['paged'];
						}
					//$wp_query = new WP_Query();
					$temp = $wp_query;
					$wp_query= null;
					$kulPost = array(
						'post_type'  => 'post',
						'author' => $user_id,
						'posts_per_page' => 12,
						'paged' => $paged,
						);
					$wp_query = new WP_Query($kulPost);
					$current = -1;
					$current2 = 0;
					$count = 0;
					?>
					<?php while ($wp_query->have_posts()) : $wp_query->the_post(); $current++; $current2++;?>
					<div class="profile-video">
						<div class="media-object stack-for-small">
							<div class="media-object-section media-img-content">
								<div class="video-img">
								<?php if ( has_post_thumbnail()) {?>
									<?php echo get_the_post_thumbnail(); ?>
								<?php }else{ ?>	
								<img src="<?php echo get_template_directory_uri() . '/assets/images/nothumb.png' ?>" alt="No Thumb"/> 
								<?php } ?>
								</div>
							</div><!--media-object-section-->
						
						<div class="media-object-section media-video-content">
							<div class="video-content">
								<h5><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h5>
								<p><?php echo substr(get_the_excerpt(), 0,260); ?></p>
							</div><!--video-content-->
							<div class="video-detail clearfix">
								<div class="video-stats">
									<span><i class="fa fa-check-square-o"></i><?php echo get_post_status( $post->ID ); ?></span>
									<?php $dateFormat = get_option( 'date_format' );?>
									<span><i class="fa fa-clock-o"></i><?php echo get_the_date($dateFormat, $post_id); ?></span>
									<span><i class="fa fa-eye"></i><?php echo betube_get_post_views($post->ID); ?></span>
								</div>
								<div class="video-btns">
								<?php 
									global $redux_demo;
									$edit_post_page_id = $redux_demo['edit_post'];
									$postID = $post->ID;
									global $wp_rewrite;
									if ($wp_rewrite->permalink_structure == ''){
										//we are using ?page_id
										$edit_post = $edit_post_page_id."&post=".$post->ID;
										$del_post = $pagepermalink."&delete_id=".$post->ID;
									}else{
										//we are using permalinks
										$edit_post = $edit_post_page_id."?post=".$post->ID;
										$del_post = $pagepermalink."?delete_id=".$post->ID;
									}
									if(get_post_status( $post->ID ) !== 'private'){
								?>
									<a class="video-btn" href="<?php echo $edit_post; ?>"><i class="fa fa-pencil-square-o"></i><?php esc_html_e("Edit", 'betube') ?></a>
									<?php } ?>									
									<a class="thickbox video-btn" href="#TB_inline?height=150&amp;width=400&amp;inlineId=examplePopup<?php echo $post->ID; ?>"><i class="fa fa-trash"></i><?php esc_html_e("Delete", 'betube') ?></a>
									<div class="delete-popup" id="examplePopup<?php echo $post->ID; ?>" style="display:none">
										<h4><?php esc_html_e("Are you sure you want to delete this?", 'betube') ?></h4>
										<a class="button-ag large green" href="<?php echo $del_post; ?>">
										<span class="button-inner"><?php esc_html_e("Confirm", 'betube') ?></span>
										</a>
									</div>
								</div>
							</div><!--video-detail-->
						</div><!--media-object-section-->
						</div><!--media-object-->
					</div><!--profile-video-->
					<?php  endwhile;	?>
					<?php
						global $redux_demo;
						$beTubeScroll = $redux_demo['infinite-scroll'];
						if($beTubeScroll == 1){
								echo infinite($wp_query);
							}else{								
								get_template_part('pagination');
							}
						//wp_reset_query();
						//get_template_part('pagination');
					?>
					<?php wp_reset_postdata();  ?>
				</div><!--large-12-->
			</div><!--row-->
		</section><!--profile-videos-->
	</div><!--Large8-->
</div><!--row-->
<?php get_footer(); ?>