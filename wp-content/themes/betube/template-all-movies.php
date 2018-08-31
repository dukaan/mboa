<?php
/**
 * Template name: All Movies
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
 * @since betube 1.0
 */
get_header(); 
betube_breadcrumbs();
 ?>
 <?php 
	global $redux_demo;
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
	$betubeGridView = $redux_demo['betube-main-grid-selection'];
	$betubeScroll = $redux_demo['infinite-scroll'];
	$betubeGoogleAdsAllVideos = $redux_demo['betube-google-ads-for-all-video-page'];
	$betubeFeaturedSlider = $redux_demo['featured-slider-on'];
	$betubeMoviesCount = $redux_demo['all-movies-page-counter'];
	$myClass = "";
	if($betubeGridView == "gridsmall"){
		$myClass = "group-item-grid-default";
	}elseif($betubeGridView == "gridmedium"){
		$myClass = "grid-medium";
	}elseif($betubeGridView == "listmedium"){
		$myClass = "list";
	}
?>
<?php 
if($betubeFeaturedSlider == 1){	
	get_template_part( 'templates/featuredvideos' );
}
?>
<section class="category-content">
	<div class="row">
		<!-- left side content area -->
		<div class="large-8 columns">
			<section class="content content-with-sidebar">
				<div class="row secBg">
					<div class="large-12 columns">
						<!--Heading-->
						<div class="main-heading movie__list_heading clearfix">
							<div class="head-title pull-left">
								<i class="fa fa-film"></i>
								<h4><?php esc_html_e('All Movies', 'betube') ?></h4>
							</div>
						</div>
						<!--Heading-->
						<!--Movies Section-->
						<div class="tabs-content" data-tabs-content="newVideos">
							<div class="tabs-panel is-active" id="new-all">
								<div class="tabs-panel is-active" id="new-all">
									<div class="row gutter__12 mr-set">
										<?php 
											global $paged, $wp_query, $wp;
											$args = wp_parse_args($wp->matched_query);
											if ( !empty ( $args['paged'] ) && 0 == $paged ) {
												$wp_query->set('paged', $args['paged']);
												$paged = $args['paged'];
											}											
											$temp = $wp_query;
											$wp_query= null;
											$arags = array(
												'post_type' => 'movies',
												'posts_per_page' => $betubeMoviesCount,
												'paged' => $paged,					
											);
											$wp_query = new WP_Query($arags);											
											$post_id = $post->ID;
											$theTitle = get_the_title($post_id);
										?>
										<?php while ($wp_query->have_posts()) : $wp_query->the_post();?>
											<div class="large-3 medium-4 columns beetube__matchheight end">
                                                <div class="post thumb-border movie__post">
                                                    <div class="post-thumb">
                                                        <?php 
														if( has_post_thumbnail()){
															$imageurl = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'beetube-movies');
															$thumb_id = get_post_thumbnail_id($post->id);
															$alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
														?>
														<img src="<?php echo esc_url($imageurl[0]); ?>" alt="<?php if(empty($alt)){echo "Image";}else{ echo $alt; } ; ?>"/>
														<?php }else{ ?>
														<img src="<?php echo get_template_directory_uri() . '/assets/images/watchmovies.png' ?>" alt="No Thumb"/>
														<?php }?>
                                                        <a href="<?php the_permalink(); ?>" class="hover-posts">
                                                            <span><i class="fa fa-play"></i>
															<?php esc_html_e('Watch movie', 'betube') ?>
															</span>
                                                        </a>
                                                    </div>
                                                    <div class="post-des text-center">
                                                        <h6>
															<a href="<?php the_permalink(); ?>"><?php echo the_title(); ?></a>
														</h6>
                                                        <span><?php esc_html_e('Views', 'betube') ?> : <?php echo betube_get_post_views(get_the_ID()); ?></span>
                                                    </div>
                                                </div>
                                            </div>
										<?php endwhile; ?>
										<!--pagination-->										
										<div class="large-12 columns">
											<?php get_template_part('pagination'); ?>
										</div>										
										<!--pagination-->
									</div><!--row gutter__12-->									
								</div><!--new-all-->
							</div><!--tabs-panel-->
						</div>
						<!--Movies Section-->
					</div><!--large-12 columns-->
				</div><!--row secBg-->
			</section><!--content content-with-sidebar-->
			<div class="googleAdv">
				<?php echo $betubeGoogleAdsAllVideos; ?>
			</div><!-- End ad Section -->
		</div><!--large8-->
		<!-- left side content area -->
		<!-- sidebar -->
		<div class="large-4 columns">
			<aside class="secBg sidebar">
				<div class="row">
					<?php get_sidebar('main'); ?>
				</div>
			</aside>
		</div><!--large4-->
		<!-- sidebar -->
	</div><!--row-->
</section><!--category-content-->
<?php get_footer(); ?>