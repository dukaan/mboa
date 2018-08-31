<?php
/**
 * The template for displaying archives of blog categories
 *
 * @package WordPress
 * @subpackage betube
 * @since betube 2.0
 */
 ?>
<?php get_header();?>
<?php betube_breadcrumbs(); ?>
<?php
global $redux_demo;
$betubeFirstSecView = $redux_demo['landing-first-grid-selection'];
$betubeFeaturedSlider = $redux_demo['featured-slider-on'];
	$myClass = "";
	if($betubeFirstSecView == "gridsmall"){
		$myClass = "group-item-grid-default";
	}elseif($betubeFirstSecView == "gridmedium"){
		$myClass = "grid-medium";
	}elseif($betubeFirstSecView == "listmedium"){
		$myClass = "list";
	}
if($betubeFeaturedSlider == 1){	
	get_template_part( 'templates/featuredvideos' );
}
?>
<?php 
$cat_id = get_queried_object_id();
$this_category = get_category($cat_id);	
$cat_parent_ID = isset( $cat_id->category_parent ) ? $cat_id->category_parent : '';
if ($cat_parent_ID == 0) {
	$tag = $cat_id;
}else{
	$tag = $cat_parent_ID;
}
$category = get_category($tag);
$count = $category->category_count;
$catName = get_cat_name( $tag );
?>
<div class="row">
	<div class="large-8 columns">
		<section class="content content-with-sidebar">
			<div class="row secBg">
				<div class="large-12 columns">
					<div class="main-heading movie__list_heading clearfix">
						<div class="head-title pull-left">
							<i class="fa fa-film"></i>
							<h4><?php echo $catName;?></h4>
						</div>
					</div>
					<div class="tabs-content" data-tabs-content="newVideos">
						<div class="tabs-panel is-active" id="new-all">
							<div class="row gutter__12 mr-set">
								<?php 
								$arags = array(
									'post_type' => 'movies',
									'posts_per_page' => 10,
									'post_status' => 'publish',
									'orderby' => 'date',
									'order' => 'DESC',									
									'tax_query' => array(
										array(
											'taxonomy' => 'movies_category',
											'field' => 'id',
											'terms' => $cat_id,
										)
									)
								);
								$wp_query= null;
								$wp_query = new WP_Query($arags);								
								?>
								<?php while ($wp_query->have_posts()) : $wp_query->the_post();?>
								<!--Single Movie-->
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
									</div><!--post-->
								</div><!--large-3-->
								<!--Single Movie-->
								<?php endwhile; ?>
							</div>
						</div>
					</div><!--tabs-content-->
				</div><!--large-12 columns-->
			</div><!--row-->
		</section><!--content content-with-sidebar-->
	</div><!--large-8 columns-->
	<div class="large-4 columns">
		<aside class="secBg sidebar">
			<div class="row">
				<?php dynamic_sidebar('category'); ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>