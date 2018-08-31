<?php
/**
 * The template for displaying the single blog posts.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage betube
 * @since betube 1.0
 */

get_header();
betube_breadcrumbs()
 ?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	global $post;
?>
<section class="category-content">
	<div class="row">
		<div class="large-8 columns">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="blog-post">
				<div class="row secBg">
					<div class="large-12 columns">
						<div class="blog-post-heading">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p>
								<span>
									<i class="fa fa-user"></i>
									<?php 										
										$user_ID = $post->post_author;
									?>
									<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author_meta('display_name', $user_ID ); ?></a>
								</span>
								<?php $beTubedateFormat = get_option( 'date_format' );?>
								<span><i class="fa fa-clock-o"></i><?php echo get_the_date($beTubedateFormat, $post_id); ?></span>
								<span><?php echo betube_get_post_views(get_the_ID()); ?></span>
								<span><i class="fa fa-commenting"></i><?php echo comments_number(); ?></span>
							</p>
						</div><!--blog-post-heading-->
						<div class="blog-post-content">
							<?php
							$thumbURL = betube_thumb_url($post_id);
							$altTag = betube_thumb_alt($post_id);
							if(!empty($thumbURL)){
							?>
							<div class="blog-post-img">
								<img src="<?php echo esc_url($thumbURL); ?>" alt="<?php echo $altTag; ?>"/>
							</div>
							<?php } ?>
							<p><?php $content = the_content(); ?></p><!--Content Area-->
							<div class="blog-post-extras">								
								<div class="tags extras">
									<button><i class="fa fa-tags"></i><?php esc_html_e( 'Tags', 'betube' ); ?></button>									
									<?php echo get_the_term_list( $post->ID, 'post_tag'); ?>
								</div><!--End Tags-->
								<div class="social-share extras">
									<div class="post-like-btn clearfix">
										<div class="easy-share" data-easyshare data-easyshare-http data-easyshare-url="<?php the_permalink(); ?>">
											<button class="float-left"><i class="fa fa-share-alt"></i><?php esc_html_e( 'Share', 'betube' ); ?></button>
											
											<!-- Facebook -->
											<button class="removeBorder" data-easyshare-button="facebook">
												<span class="fa fa-facebook"></span>
											</button>
											
											<!-- Twitter -->
											<button class="removeBorder" data-easyshare-button="twitter" data-easyshare-tweet-text="">
												<span class="fa fa-twitter"></span>
											</button>
											
											<!-- Google+ -->
											<button class="removeBorder" data-easyshare-button="google">
												<span class="fa fa-google-plus"></span>
											</button>
											<div data-easyshare-loader><?php esc_html_e( 'Loading...', 'betube' ); ?></div>
										</div><!--Easy Share-->
									</div><!--post-like-btn-->
								</div><!--Social Share-->
							</div><!--blog-post-extras-->
							<!--Next Previous Post Button-->
							<div class="blog-pagination text-center">
								<?php previous_post_link( '%link', '<i class="fa fa-long-arrow-left left-arrow"></i>' . __( 'Previous Post', 'betube' ) ); ?>
								
								<?php next_post_link( '%link',__( 'Next Post', 'betube' ).'<i class="fa fa-long-arrow-right right-arrow"></i>' ); ?>
							</div>
							<!--Next Previous Post Button-->
						</div><!--blog-post-content-->
					</div><!--large12-->
				</div><!--row secBg-->
			</div><!--blog-post-->
			<div class="blog-post-written">
				<div class="row secBg">
					<div class="large-12 columns">
						<div class="media-object">
							<div class="media-object-section">
							<?php 								
								$user_ID = $post->post_author;
								$authorAvatarURL = get_user_meta($user_ID, "betube_author_avatar_url", true);
								if(!empty($authorAvatarURL)) {
									$authorAvatarURL = betube_get_image_url($authorAvatarURL);
									?>
								<div class="blog-post-author-img">
									<img src="<?php echo esc_url($authorAvatarURL); ?>" alt="blog post author">
								</div>
									<?php
								}else{
									$authorID = get_the_author_meta('user_email', $user_ID);
									$avatar_url = betube_get_avatar_url($authorID, $size = '150' );
							?>
								<div class="blog-post-author-img">
									<img class="avatar" src="<?php echo $avatar_url; ?>" alt="" />
								</div><!--blog-post-author-img-->
								<?php }?>	
							</div><!--media-object-section-->
							<div class="media-object-section">
								<div class="blog-post-author-des">
									<h5><?php esc_html_e( 'Written by', 'betube' ); ?>&nbsp;<?php echo get_the_author_meta('display_name', $user_ID ); ?></h5>
									<p><?php $author_desc = get_the_author_meta('description', $user_ID); echo $author_desc; ?></p>
								</div><!--blog-post-author-des-->
							</div><!--media-object-section-->
						</div><!--media-object-->
					</div><!--large-12-->
				</div><!--row secBg-->
			</div><!--blog-post-written-->
			<?php endwhile; endif; ?>
			<!--Start Comments-->
			<section class="content comments">
				<div class="row secBg">
				<?php 
					$file ='';
					$separate_comments ='';
					comments_template( $file, $separate_comments );
				?>
				</div>
			</section>
			<!--End Comments-->
			<?php 
			global $redux_demo;
			$betubeBlogsAds = $redux_demo['betube-google-ads-for-blog'];
			?>
			<div class="googleAdv">
				<?php echo $betubeBlogsAds; ?>
			</div><!-- End ad Section -->
		</div><!--Large8-->
		<div class="large-4 columns">
			<aside class="secBg sidebar">
				<div class="row">
					<?php get_sidebar('blog'); ?>
				</div>
			</aside>
		</div><!--large-4-->
	</div><!--ROW-->
</section><!--category-content-->
<?php get_footer(); ?>