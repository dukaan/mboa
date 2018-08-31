<?php
/**
 * Template name: All Users
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage betube
 * @since betube 1.0.8
 */


?>
<?php 
get_header();
betube_breadcrumbs();
$page = get_page($post->ID);
$current_page_id = $page->ID;
global $redux_demo;
$betubeFeaturedSlider = $redux_demo['featured-slider-on'];
$betubeUserLimit = $redux_demo['author_limit_all'];
if($betubeFeaturedSlider == 1){	
	get_template_part( 'templates/featuredvideos' );
}
?>
<section class="category-content">
	<div class="row">
		<!-- left side content area -->
		<div class="large-8 columns">
			<section class="content content-with-sidebar">
				<!--Title-->
				<div class="main-heading removeMargin">
					<div class="row secBg padding-14 removeBorderBottom">
						<div class="medium-8 small-8 columns">
							<div class="head-title">
								<i class="fa fa-film"></i>
								<h4><?php esc_html_e('All Authors', 'betube') ?></h4>
							</div>
						</div>
					</div>
				</div>
				<!--Title-->
				<div class="row secBg all-author">
					<?php 
					$limit = $betubeUserLimit;
					$current_page = max( 1, get_query_var('paged') );
					$offset = ($current_page - 1) * $limit;
						$defaultsauthors = array(
							'orderby' => 'display_name',
							'order' => 'ASC',
							'number' => $limit,
							'offset' => $offset,
							'exclude_admin' => true,							
						);
						$number_of_users = (int)count(get_users());
						$user_query = new WP_User_Query( $defaultsauthors );
						$total_pages =  ceil( $number_of_users / $limit ) ;
						$allAuthors = get_users();						
						if( ! empty( $user_query->results ) ){
							foreach ( $user_query->results as $user ) {								
								$authorDisplayName = $user->display_name;
								$authorEmail = $user->user_email;
								$profileName = $user->user_nicename;								
								$authorID = $user->ID;
								$profileURL = get_author_posts_url($authorID, $profileName);
								$authorAvatarURL = get_user_meta($authorID, "betube_author_avatar_url", true);
								$authorAvatarURL = betube_get_image_url($authorAvatarURL);
								if(empty($authorAvatarURL)){
									$authorProfileIMG = betube_get_avatar_url($authorEmail, $size = '140' );
								}else{
									$authorProfileIMG = $authorAvatarURL;
								}
								?>
								<div class="large-4 small-6 medium-3 columns end">
									<div class="follower">
										<div class="follower-img">									
											<img src="<?php echo $authorProfileIMG; ?>" alt="<?php echo $authorDisplayName; ?>">
										</div>
										<span><a href="<?php echo $profileURL; ?>"><?php echo $authorDisplayName; ?></a></span>
									</div>
								</div>
								<?php
							}
						}else{
							echo "No Found";
						}
						echo '<br clear=all />';
						echo '<div class="pagination">';
						echo paginate_links( array(
							'base' => get_pagenum_link(1) . '%_%',
							'format' => 'page/%#%/',
							'prev_text' => __('Previous Page', 'betube'), // text for previous page
							'next_text' => __('Next Page', 'betube'), // text for next page
							'current' => max( 1, get_query_var('paged') ),
							'total' => $total_pages,
						) );
						echo '</div>';
						
					?>
				</div><!--row-->
			</section><!--content content-with-sidebar-->
			<!-- ad Section -->
			<?php 
				global $redux_demo;
				$beTubeCatAds = $redux_demo['betube-google-ads-for-category-page'];
			?>
			<div class="googleAdv">
				<?php echo $beTubeCatAds; ?>
			</div><!-- End ad Section -->
			<!-- ad Section -->
		</div>
		<!-- left side content area -->
		<!-- sidebar -->
		<div class="large-4 columns">
			<aside class="secBg sidebar">
				<div class="row">
					<?php get_sidebar('main'); ?>
				</div>
			<aside>
		</div>
		<!-- sidebar -->
	</div><!--row-->
</section>
<?php get_footer(); ?>